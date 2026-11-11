
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StockPilot - Ingredients Export</title>

    <!-- jsPDF -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

    <!-- jsPDF AutoTable -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.8.2/jspdf.plugin.autotable.min.js"></script>

    <!-- jsPDF Library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

    <!-- jsPDF AutoTable Plugin -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.8.2/jspdf.plugin.autotable.min.js"></script>
</head>
<body>

    <p id="status">Preparing your PDF export...</p>

    <button id="downloadButton" onclick="generatePDF()" style="display:none;">
        Download PDF
    </button>

    <script>
        const ingredients = {{ Illuminate\Support\Js::from($ingredients) }};

        function generatePDF() {
            const { jsPDF } = window.jspdf;

            const doc = new jsPDF({
                orientation: 'landscape',
                unit: 'mm',
                format: 'a4'
            });

            // Report title
            doc.setFontSize(18);
            doc.setFont('helvetica', 'bold');
            doc.text('StockPilot - Ingredients & Supplies', 14, 18);

            // Report information
            doc.setFontSize(10);
            doc.setFont('helvetica', 'normal');
            doc.text('Inventory Report', 14, 25);
            doc.text('Generated: ' + new Date().toLocaleDateString(), 14, 31);
            doc.text('Total Records: ' + ingredients.length, 14, 37);

            // Prepare table rows
            const rows = ingredients.map(item => {
                const status = Number(item.quantity) <= Number(item.min_quantity)
                    ? 'Low Stock'
                    : 'In Stock';

                return [
                    item.name ?? 'N/A',
                    item.category ?? 'N/A',
                    item.quantity ?? 0,
                    item.unit ?? 'N/A',
                    item.min_quantity ?? 0,
                    item.supplier ?? 'N/A',
                    status
                ];
            });

            // Generate table
            doc.autoTable({
                startY: 44,
                head: [[
                    'Ingredient',
                    'Category',
                    'Quantity',
                    'Unit',
                    'Minimum Stock',
                    'Supplier',
                    'Status'
                ]],
                body: rows,

                theme: 'grid',

                styles: {
                    fontSize: 9,
                    cellPadding: 3,
                    valign: 'middle'
                },

                headStyles: {
                    fillColor: [31, 61, 69],
                    textColor: 255,
                    fontStyle: 'bold'
                },

                alternateRowStyles: {
                    fillColor: [245, 247, 249]
                },

                columnStyles: {
                    0: { cellWidth: 48 },
                    1: { cellWidth: 35 },
                    2: { cellWidth: 25 },
                    3: { cellWidth: 20 },
                    4: { cellWidth: 30 },
                    5: { cellWidth: 55 },
                    6: { cellWidth: 30 }
                },

                didParseCell: function(data) {
                    if (data.section === 'body' && data.column.index === 6) {
                        if (data.cell.raw === 'Low Stock') {
                            data.cell.styles.textColor = [220, 53, 69];
                            data.cell.styles.fontStyle = 'bold';
                        } else {
                            data.cell.styles.textColor = [25, 135, 84];
                        }
                    }
                }
            });

            // Add page numbers
            const pageCount = doc.internal.getNumberOfPages();

            for (let i = 1; i <= pageCount; i++) {
                doc.setPage(i);
                doc.setFontSize(8);
                doc.text(
                    'Page ' + i + ' of ' + pageCount,
                    doc.internal.pageSize.getWidth() - 14,
                    doc.internal.pageSize.getHeight() - 8,
                    { align: 'right' }
                );
            }

            // Download PDF
            doc.save('stockpilot-ingredients-' + new Date().toISOString().slice(0, 10) + '.pdf');
        }

        // Automatically generate the PDF
        window.onload = function() {
            if (window.jspdf && window.jspdf.jsPDF) {
                generatePDF();
            } else {
                document.getElementById('status').textContent =
                    'PDF libraries could not load. Please check your internet connection.';
                document.getElementById('downloadButton').style.display = 'inline-block';
            }
        };
    </script>

    <script>
    async function exportIngredientsPDF() {

        // Retrieve all matching ingredients from Laravel
        const response = await fetch(
            @json(route('ingredients.export-pdf', request()->query()))
        );

        if (!response.ok) {
            alert('Unable to retrieve ingredient records. Please try again.');
            return;
        }

        const ingredients = await response.json();

        // Check if jsPDF is available
        if (!window.jspdf || !window.jspdf.jsPDF) {
            alert('PDF library could not load. Please check your internet connection.');
            return;
        }

        const { jsPDF } = window.jspdf;

        // Create landscape A4 PDF
        const doc = new jsPDF({
            orientation: 'landscape',
            unit: 'mm',
            format: 'a4'
        });

        // Report title
        doc.setFontSize(18);
        doc.setFont('helvetica', 'bold');
        doc.text('StockPilot - Ingredients & Supplies', 14, 18);

        // Report information
        doc.setFontSize(10);
        doc.setFont('helvetica', 'normal');
        doc.text('Inventory Report', 14, 25);
        doc.text('Generated: ' + new Date().toLocaleDateString(), 14, 31);
        doc.text('Total Records: ' + ingredients.length, 14, 37);

        // Prepare table data
        const rows = ingredients.map(item => {

            const status = Number(item.quantity) <= Number(item.min_quantity)
                ? 'Low Stock'
                : 'In Stock';

            return [
                item.name ?? 'N/A',
                item.category ?? 'N/A',
                item.quantity ?? 0,
                item.unit ?? 'N/A',
                item.min_quantity ?? 0,
                item.supplier ?? 'N/A',
                status
            ];
        });

        // Generate PDF table
        doc.autoTable({
            startY: 44,

            head: [[
                'Ingredient',
                'Category',
                'Quantity',
                'Unit',
                'Minimum Stock',
                'Supplier',
                'Status'
            ]],

            body: rows,

            theme: 'grid',

            styles: {
                fontSize: 9,
                cellPadding: 3,
                valign: 'middle'
            },

            headStyles: {
                fillColor: [31, 61, 69],
                textColor: 255,
                fontStyle: 'bold'
            },

            alternateRowStyles: {
                fillColor: [245, 247, 249]
            },

            didParseCell: function(data) {

                if (data.section === 'body' && data.column.index === 6) {

                    if (data.cell.raw === 'Low Stock') {
                        data.cell.styles.textColor = [220, 53, 69];
                        data.cell.styles.fontStyle = 'bold';
                    } else {
                        data.cell.styles.textColor = [25, 135, 84];
                    }
                }
            }
        });

        // Add page numbers
        const pageCount = doc.internal.getNumberOfPages();

        for (let i = 1; i <= pageCount; i++) {

            doc.setPage(i);
            doc.setFontSize(8);

            doc.text(
                'Page ' + i + ' of ' + pageCount,
                doc.internal.pageSize.getWidth() - 14,
                doc.internal.pageSize.getHeight() - 8,
                { align: 'right' }
            );
        }

        // Download PDF without leaving the current page
        doc.save(
            'stockpilot-ingredients-' +
            new Date().toISOString().slice(0, 10) +
            '.pdf'
        );
    }
    </script>


</body>
</html>
