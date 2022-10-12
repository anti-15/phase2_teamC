import '@fullcalendar/core/vdom'; // for Vite
import { Calendar } from "@fullcalendar/core";
import interactionPlugin from "@fullcalendar/interaction";
import dayGridPlugin from "@fullcalendar/daygrid";
import timeGridPlugin from "@fullcalendar/timegrid";
import listPlugin from "@fullcalendar/list";
import { formatDate } from '@fullcalendar/core'

const calendarEl = document.getElementById("calendar");

// let 変数。再代入可能。
// const 定数。再代入不可。

const calendar = new Calendar(calendarEl, {
    plugins: [interactionPlugin, dayGridPlugin, timeGridPlugin, listPlugin],
    initialView: "dayGridMonth",
    editable: true,
    headerToolbar: {
        left: "prev,next today",
        center: "title",
        right: "dayGridMonth,timeGridWeek,listWeek",
    },
    events: '/full-calendar',
    selectable: true,
    selectHelper: true,
    locale: "ja",
    select: async function (start, end, allDay) {
        var title = prompt('Event Title:');

        if (title) {
            var start = formatDate(start, 'Y-MM-DD HH:mm:ss')
            var end = formatDate(end, 'Y-MM-DD HH:mm:ss')

            try {
                const response = await fetch("/full-calendar/action", {
                    method: 'POST',
                    body: JSON.stringify({
                        title: title,
                        start: start,
                        end: end,
                        type: 'add'
                    })
                })
                if (!response.ok) {
                    console.error('response.ok:', response.ok);
                    console.error('esponse.status:', response.status);
                    console.error('esponse.statusText:', response.statusText);
                    throw new Error(response.statusText);
                }
                calendar.refetchEvents();
                alert("Event Created Successfully");
            } catch (error) {
                alert(`Error: ${error}`);
            }
        }
    },
    // eventResize: function (event, delta) {
    //     var start = $.fullCalendar.formatDate(event.start, 'Y-MM-DD HH:mm:ss');
    //     var end = $.fullCalendar.formatDate(event.end, 'Y-MM-DD HH:mm:ss');
    //     var title = event.title;
    //     var id = event.id;
    //     $.ajax({
    //         url: "/full-calendar/action",
    //         type: "POST",
    //         data: {
    //             title: title,
    //             start: start,
    //             end: end,
    //             id: id,
    //             type: 'update'
    //         },
    //         success: function (response) {
    //             calendar.fullCalendar('refetchEvents');
    //             alert("Event Updated Successfully");
    //         }
    //     })
    // },
    // eventDrop: function (event, delta) {
    //     var start = $.fullCalendar.formatDate(event.start, 'Y-MM-DD HH:mm:ss');
    //     var end = $.fullCalendar.formatDate(event.end, 'Y-MM-DD HH:mm:ss');
    //     var title = event.title;
    //     var id = event.id;
    //     $.ajax({
    //         url: "/full-calendar/action",
    //         type: "POST",
    //         data: {
    //             title: title,
    //             start: start,
    //             end: end,
    //             id: id,
    //             type: 'update'
    //         },
    //         success: function (response) {
    //             calendar.fullCalendar('refetchEvents');
    //             alert("Event Updated Successfully");
    //         }
    //     })
    // },

    // eventClick: function (event) {
    //     if (confirm("Are you sure you want to remove it?")) {
    //         var id = event.id;
    //         $.ajax({
    //             url: "/full-calendar/action",
    //             type: "POST",
    //             data: {
    //                 id: id,
    //                 type: "delete"
    //             },
    //             success: function (response) {
    //                 calendar.fullCalendar('refetchEvents');
    //                 alert("Event Deleted Successfully");
    //             }
    //         })
    //     }
    // }
});
calendar.render();
