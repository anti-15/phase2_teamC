import '@fullcalendar/core/vdom'; // for Vite
import { Calendar } from "@fullcalendar/core";
import interactionPlugin from "@fullcalendar/interaction";
import dayGridPlugin from "@fullcalendar/daygrid";
import timeGridPlugin from "@fullcalendar/timegrid";
import listPlugin from "@fullcalendar/list";


var calendarEl = document.getElementById("calendar");

let calendar = new Calendar(calendarEl, {
    plugins: [interactionPlugin,dayGridPlugin,timeGridPlugin,listPlugin],
    initialView: "dayGridMonth",
    headerToolbar: {
        left: "prev,next today",
        center: "title",
        right: "dayGridMonth,timeGridWeek,listWeek",
    },
    locale: "ja",

    // 日付をクリック、または範囲を選択したイベント
    selectable: true,
    select: function (info) {
        //alert("selected " + info.startStr + " to " + info.endStr);
        //入力ダイアログ
        const eventName = prompt("イベントを入力してください");
        
        if (eventName) {
            // イベントの追加
            calendar.addEvent({
                title: eventName,
                start: info.start,
                end: info.end,
                allDay: true,
            });
        }
    },
});
calendar.render();