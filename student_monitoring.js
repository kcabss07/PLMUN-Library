function onScanSuccess(decodedText, decodedResult) {
    // Assuming the QR code contains student information in JSON format
    try {
        const studentData = JSON.parse(decodedText);

        // Populate the form fields with the scanned data
        document.getElementById('student_number').value = studentData.student_number;
        document.getElementById('last_name').value = studentData.last_name;
        document.getElementById('first_name').value = studentData.first_name;
        document.getElementById('course').value = studentData.course;
        document.getElementById('year_level').value = studentData.year_level;

        
    } catch (error) {
        alert("Invalid QR code. Please scan a valid student QR code.");
    }
}

function onScanFailure(error) {
    console.warn(`QR scan failed: ${error}`);
}

// Initialize the QR scanner
let html5QrCode = new Html5Qrcode("qr-reader");

html5QrCode.start(
    { facingMode: "environment" }, // Use the rear camera
    {
        fps: 10,    // Scans per second
        qrbox: { width: 250, height: 250 }  // Define scanning box size
    },
    onScanSuccess,
    onScanFailure
).catch(err => {
    console.error(`Unable to start scanning, error: ${err}`);
});
// Search functionality
document.getElementById('search').addEventListener('keyup', function() {
    var searchValue = this.value.toLowerCase();
    var rows = document.querySelectorAll('#transactionTable tbody tr');
    rows.forEach(function(row) {
        var cells = row.querySelectorAll('td');
        var match = false;
        cells.forEach(function(cell) {
            if (cell.textContent.toLowerCase().includes(searchValue)) {
                match = true;
            }
        });
        row.style.display = match ? '' : 'none';
    });
});

// Filter by date functionality
function filterByDate() {
    var dateType = document.getElementById('date-type').value;
    var startDate = document.getElementById('start-date').value;
    var endDate = document.getElementById('end-date').value;
    var rows = document.querySelectorAll('#transactionTable tbody tr');
    rows.forEach(function(row) {
        var dateValue = row.querySelector('td:nth-child(' + (dateType === 'entry_time' ? 6 : 7) + ')').textContent;
        var showRow = true;
        if (startDate && dateValue < startDate) {
            showRow = false;
        }
        if (endDate && dateValue > endDate) {
            showRow = false;
        }
        row.style.display = showRow ? '' : 'none';
    });
}

// Print functionality
function printTable() {
    var printContents = document.querySelector('.transaction-list').innerHTML;
    var originalContents = document.body.innerHTML;
    document.body.innerHTML = '<h2>In and Out List</h2>' + printContents;
    window.print();
    document.body.innerHTML = originalContents;
    location.reload();
}

// Export to Excel functionality
function exportTableToExcel(tableID, filename = '') {
    var downloadLink;
    var dataType = 'application/vnd.ms-excel';
    var tableSelect = document.getElementById(tableID);
    var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');

    // Specify file name
    filename = filename ? filename + '.xls' : 'excel_data.xls';

    // Create download link element
    downloadLink = document.createElement('a');

    document.body.appendChild(downloadLink);

    if (navigator.msSaveOrOpenBlob) {
        var blob = new Blob(['\ufeff', tableHTML], {
            type: dataType
        });
        navigator.msSaveOrOpenBlob(blob, filename);
    } else {
        // Create a link to the file
        downloadLink.href = 'data:' + dataType + ', ' + tableHTML;

        // Setting the file name
        downloadLink.download = filename;

        // Triggering the function
        downloadLink.click();
    }
}


