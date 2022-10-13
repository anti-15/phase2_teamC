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
    events: '/schedule',
    selectable: true,
    selectHelper: true,
    locale: "ja",
    select: async function (info) {
        var title = prompt('Event Title:');
        var description = prompt('Event Description:');

        if (title && description) {
            console.log(document.querySelector('meta[name="csrf-token"]').content)
            try {

                const response = await fetch("/schedule/add", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                    body: JSON.stringify({
                        title: title,
                        start: info.start,
                        end: info.end,
                        description: description,
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
    eventResize: async function (info) {
        try {
            console.log(info.event.id);
            console.log(info.event.start);
            console.log(info.event.end);

            const response = await fetch(`/schedule/${info.event.id}`, {
                method: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
                body: JSON.stringify({
                    start: info.event.start,
                    end: info.event.end,
                })
            })
            if (!response.ok) {
                console.error('response.ok:', response.ok);
                console.error('esponse.status:', response.status);
                console.error('esponse.statusText:', response.statusText);
                throw new Error(response.statusText);
            }
            calendar.refetchEvents();
            alert("Event Updated Successfully");
        } catch (error) {
            alert(`Error: ${error}`);
        }
    },
    eventDrop: async function (info) {
        try {
            const response = await fetch(`/schedule/${info.event.id}`, {
                method: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
                body: JSON.stringify({
                    start: info.event.start,
                    end: info.event.end,
                })
            })
            if (!response.ok) {
                console.error('response.ok:', response.ok);
                console.error('esponse.status:', response.status);
                console.error('esponse.statusText:', response.statusText);
                throw new Error(response.statusText);
            }
            calendar.refetchEvents();
            alert("Event Updated Successfully");
        } catch (error) {
            alert(`Error: ${error}`);
        }
    },

    eventClick: async function (info) {
        if (confirm("Are you sure you want to remove it?")) {
            try {
                const response = await fetch(`/schedule/${info.event.id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                })
                if (!response.ok) {
                    console.error('response.ok:', response.ok);
                    console.error('esponse.status:', response.status);
                    console.error('esponse.statusText:', response.statusText);
                    throw new Error(response.statusText);
                }
                calendar.refetchEvents();
                alert("Event Deleted  Successfully");
            } catch (error) {
                alert(`Error: ${error}`);
            }
        }
    }
});
calendar.render();
