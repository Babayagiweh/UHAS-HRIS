$(document).ready(function() {
    // Initialize FullCalendar
    $('#calendar').fullCalendar({
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
        },
        events: function(start, end, timezone, callback) {
            // Example events, can be fetched from the database (replace with AJAX call)
            var events = [
                {
                    title: 'New Year Seminar',
                    start: '2024-12-25T09:00:00',
                    end: '2024-12-25T15:00:00',
                    description: 'A seminar on the theme of New Year resolutions for academic excellence.',
                    location: 'University Main Hall',
                    color: '#ff6347'
                },
                {
                    title: 'Staff Retreat',
                    start: '2024-01-05T08:00:00',
                    end: '2024-01-07T18:00:00',
                    description: 'A retreat to enhance team spirit and productivity.',
                    location: 'UHAS Retreat Center',
                    color: '#32cd32'
                }
            ];

            callback(events);
        },
        eventClick: function(event) {
            // Show event details dynamically
            $('#event-details').removeClass('d-none');
            $('#event-description').html(
                `<h3>${event.title}</h3>
                <p><strong>Description:</strong> ${event.description}</p>
                <p><strong>Location:</strong> ${event.location}</p>
                <p><strong>Date:</strong> ${event.start.format('MMMM Do YYYY, h:mm a')} - ${event.end.format('h:mm a')}</p>`
            );
        }
    });

    // Optional: Add Animation on Page Load
    $('body').addClass('animate__animated animate__fadeIn');
});
