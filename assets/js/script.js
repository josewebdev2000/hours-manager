$(document).ready(function() {
    var ctx = document.getElementById('hoursChart').getContext('2d');
    var hoursChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
            datasets: [{
                label: 'Hours worked',
                data: [5, 6, 4, 6, 8, 0, 0],
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    $('#calendar').fullCalendar({
        header: {
            left: 'prev,next',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
        },
        defaultDate: moment().format('YYYY-MM-DD'),
        navLinks: true,
        editable: true,
        eventLimit: true,
        events: []
    });
});
