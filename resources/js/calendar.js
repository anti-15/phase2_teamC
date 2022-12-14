import "@fullcalendar/core/vdom"; // for Vite
import { Calendar } from "@fullcalendar/core";
import interactionPlugin from "@fullcalendar/interaction";
import dayGridPlugin from "@fullcalendar/daygrid";
import timeGridPlugin from "@fullcalendar/timegrid";
import listPlugin from "@fullcalendar/list";

const calendarEl = document.getElementById("calendar");

const calendar = new Calendar(calendarEl, {
    plugins: [interactionPlugin, dayGridPlugin, timeGridPlugin, listPlugin],
    initialView: "dayGridMonth",
    editable: true,
    headerToolbar: {
        left: "prev,next today",
        center: "title",
        right: "dayGridMonth,timeGridWeek,listWeek",
    },
    buttonText: {
        today: '今日',
        month: '月',
        week: '週',
        list: 'リスト',
    },
    events: '/schedule',
    selectable: true,
    selectHelper: true,
    locale: "ja",
    select: async function (info) {
        var title = prompt('Event Title:');
        var description = prompt('Event Description:');

        if (title && description) {
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
                    throw new Error(response.statusText);
                }
                calendar.refetchEvents();
            } catch (error) {
                alert(`Error: ${error}`);
            }
        }
    },
    eventResize: async function (info) {
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
                throw new Error(response.statusText);
            }
            calendar.refetchEvents();
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
                throw new Error(response.statusText);
            }
            calendar.refetchEvents();
        } catch (error) {
            alert(`Error: ${error}`);
        }
    },
    eventClick: async function (info) {
        window.location.href = ` /schedule/${info.event.id}`;
    },
});
calendar.render();
