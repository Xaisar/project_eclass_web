$(async function(){
    var res = await getEvents()

    if(res.status == 200){
        var events = res.response.events
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            plugins: ['dayGrid', 'timeGrid', 'bootstrap'],
            initialView: 'dayGridMonth',
            initialDate: new Date,
            events: events,
        });
        calendar.render();
    } else {
        if(res.status == 401){
            window.location.reload()
        } else {
            showToast('warning', res.response.message)
        }
    }
})

async function getEvents()
{
    const res = await fetch(`${$('meta[name="base-url"]').attr('content')}/teacher/calendar/events/get-events`)
    return {status: await res.status, response: await res.json()}
}