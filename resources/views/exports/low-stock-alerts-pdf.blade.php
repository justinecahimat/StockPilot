
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StockPilot - Exporting Alerts</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }

        .export-container {
            background: white;
            padding: 35px;
            border-radius: 12px;
            text-align: center;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            max-width: 420px;
            width: 90%;
        }

        h2 {
            color: #107c57;
            margin-bottom: 10px;
        }

        p {
            color: #666;
            font-size: 14px;
        }

        button {
            background: #107c57;
            color: white;
            border: none;
            padding: 11px 22px;
            border-radius: 6px;
            cursor: pointer;
            margin-top: 15px;
        }

        button:hover {
            background: #0c6346;
        }

        #status {
            margin-top: 15px;
            font-size: 13px;
        }
    </style>
</head>

<body>

    <div class="export-container">
        <h2>StockPilot</h2>

        <h3>Low-Stock Alerts Report</h3>

        <p id="status">Preparing your PDF report...</p>

        <button id="downloadPdf" type="button">
            Download PDF
        </button>
    </div>

    <!-- jsPDF Library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

    <!-- jsPDF AutoTable Plugin -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.8.2/jspdf.plugin.autotable.min.js"></script>

    <script>
        // Receive alert records from Laravel
        const alerts = {{ \Illuminate\Support\Js::from(
            $alerts->map(function ($ingredient) {
                return [
                    'name' => $ingredient->name,
                    'quantity' => $ingredient->quantity,
                    'min_quantity' => $ingredient->min_quantity,
                    'unit' => $ingredient->unit ?? 'N/A',
                    'expiration_date' => $ingredient->expiration_date
                        ? \Carbon\Carbon::parse($ingredient->expiration_date)->format('M d, Y')
                        : 'N/A',
                    'alert_status' => $ingredient->alert_status
                ];
            })->values()
        ) }};

        const reportDate = {{ \Illuminate\Support\Js::from($today->format('F d, Y')) }};
        const filenameDate = {{ \Illuminate\Support\Js::from($today->format('Y-m-d')) }};

        function downloadAlertsPdf() {

            if (!window.jspdf || typeof window.jspdf.jsPDF !== 'function') {
                throw new Error('jsPDF library could not be loaded.');
            }

            const { jsPDF } = window.jspdf;

            const doc = new jsPDF({
                orientation: 'landscape',
                unit: 'mm',
                format: 'a4'
            });

            // Report heading
            doc.setFont('helvetica', 'bold');
            doc.setFontSize(20);
            doc.setTextColor(16, 124, 87);

            doc.text('STOCKPILOT', 14, 18);

            doc.setFontSize(11);
            doc.setTextColor(80, 80, 80);

            doc.text('RESTAURANT INVENTORY SYSTEM', 14, 25);

            doc.setFontSize(15);
            doc.setTextColor(30, 30, 30);

            doc.text('Low-Stock Alerts Report', 14, 36);

            // Report information
            doc.setFontSize(9);
            doc.setFont('helvetica', 'normal');

            doc.text('Report Date: ' + reportDate, 14, 44);

            doc.text(
                'Total Alert Records: ' + alerts.length,
                14,
                50
            );

            // Prepare table rows
            const tableRows = alerts.map(item => [
                item.name,
                String(item.quantity),
                String(item.min_quantity),
                item.unit,
                item.expiration_date,
                item.alert_status
            ]);

            // Generate table
            doc.autoTable({
                startY: 57,

                head: [[
                    'Ingredient',
                    'Quantity',
                    'Minimum Stock',
                    'Unit',
                    'Expiration Date',
                    'Alert Status'
                ]],

                body: tableRows,

                theme: 'grid',

                styles: {
                    font: 'helvetica',
                    fontSize: 8,
                    cellPadding: 3,
                    overflow: 'linebreak'
                },

                headStyles: {
                    fillColor: [17, 30, 46],
                    textColor: [255, 255, 255],
                    fontStyle: 'bold'
                },

                columnStyles: {
                    0: { cellWidth: 55 },
                    1: { cellWidth: 30 },
                    2: { cellWidth: 35 },
                    3: { cellWidth: 25 },
                    4: { cellWidth: 45 },
                    5: { cellWidth: 55 }
                },

                didParseCell: function (data) {

                    if (data.section === 'body' && data.column.index === 5) {

                        const status = data.cell.raw;

                        if (status === 'Critical') {
                            data.cell.styles.textColor = [220, 53, 69];
                        } else if (status === 'Low Stock') {
                            data.cell.styles.textColor = [253, 126, 20];
                        } else if (status === 'Expired') {
                            data.cell.styles.textColor = [132, 32, 41];
                        } else if (status === 'Expiring Soon') {
                            data.cell.styles.textColor = [181, 129, 5];
                        }

                        data.cell.styles.fontStyle = 'bold';
                    }
                }
            });

            // Add footer to every page
            const pageCount = doc.internal.getNumberOfPages();

            for (let page = 1; page <= pageCount; page++) {

                doc.setPage(page);

                const pageHeight = doc.internal.pageSize.height;
                const pageWidth = doc.internal.pageSize.width;

                doc.setFontSize(8);
                doc.setTextColor(120, 120, 120);

                doc.text(
                    'Generated by StockPilot Inventory Management System',
                    14,
                    pageHeight - 10
                );

                doc.text(
                    'Page ' + page + ' of ' + pageCount,
                    pageWidth - 14,
                    pageHeight - 10,
                    { align: 'right' }
                );
            }

            // Download the actual PDF file
            doc.save('stockpilot-alerts-' + filenameDate + '.pdf');

            document.getElementById('status').textContent =
                'Your PDF report has been generated.';
        }

        // Download button
        document.getElementById('downloadPdf').addEventListener('click', function () {

            try {
                downloadAlertsPdf();
            } catch (error) {
                document.getElementById('status').textContent =
                    'PDF generation failed: ' + error.message;

                console.error(error);
            }

        });

        // Automatically download when the page loads
        window.addEventListener('load', function () {

            try {
                downloadAlertsPdf();
            } catch (error) {
                document.getElementById('status').textContent =
                    'Automatic download failed. Please use the Download PDF button.';

                console.error(error);
            }

        });
    </script>

</body>
</html>
