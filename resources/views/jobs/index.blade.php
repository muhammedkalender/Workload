<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="{{asset('/component/boostrap/bootstrap.min.css')}}">
    <script src="{{asset('/component/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('/component/popper/popper.min.js')}}"></script>
    <script src="{{asset('/component/boostrap/bootstrap.min.js')}}"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="{{asset('/css/card-box.css" rel="stylesheet')}}">

    <title>İş Yücü</title>
</head>
<body>
<div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom shadow-sm">
    <h5 class="my-0 mr-md-auto font-weight-normal">Haftalık İş Yükü</h5>
</div>


<div class="container">
    <link href='{{asset('/component/fullcalendar/packages/core/main.css')}}' rel='stylesheet'/>
    <link href='{{asset('/component/fullcalendar/packages/daygrid/main.css')}}' rel='stylesheet'/>
    <link href='{{asset('/component/fullcalendar/packages/timegrid/main.css')}}' rel='stylesheet'/>
    <link href='{{asset('/component/fullcalendar/packages/list/main.css')}}' rel='stylesheet'/>
    <script src='{{asset('/component/fullcalendar/packages/core/main.js')}}'></script>
    <script src='{{asset('/component/fullcalendar/packages/interaction/main.js')}}'></script>
    <script src='{{asset('/component/fullcalendar/packages/daygrid/main.js')}}'></script>
    <script src='{{asset('/component/fullcalendar/packages/timegrid/main.js')}}'></script>
    <script src='{{asset('/component/fullcalendar/packages/list/main.js')}}'></script>
    <script src='{{asset('/js/reservation.js')}}'></script>
    <div class="row">
        <div class="col-md-3">
            <label for="developer">Geliştirici</label>
            <select class="form-control" id="developer" onchange="loadDeveloper(this.value)">
                @foreach($developers as $developer)
                    <option value="{{ $loop->index }}">{{$developer->name}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="totalHours">Toplam Saat / Hafta</label>
                <input type="text" class="form-control" id="totalHours" value="210 Saat / 45 Hafta" readonly>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="startDate">Başlangıç Tarihi</label>
                <input type="text" class="form-control" id="startDate" value="2020-11-02 09:00:00" readonly>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="endDate">Bitiş Tarihi</label>
                <input type="text" class="form-control" id="endDate" value="210" readonly>
            </div>
        </div>
    </div>
    <hr>
    <div id='calendar'></div>
</div>
</body>

<script>
    var events = [];
    var fullData = @json($jobs);

    const startHour = 9;
    const endHour = 18;

    document.addEventListener('DOMContentLoaded', function () {
        Date.prototype.addHours = function (h) {
            this.setTime(this.getTime() + (h * 60 * 60 * 1000));
            return this;
        }

        Date.prototype.addDays = function (d) {
            this.setTime(this.getTime() + (d * 24 * 60 * 60 * 1000));
            return this;
        }

        Date.prototype.nextDay = function () {
            this.setTime(this.getTime() + (24 * 60 * 60 * 1000));
            this.setHours(startHour);
            this.setMinutes(0);
            this.setSeconds(0);

            if(this.getDay() == 6){
                this.addDays(2)
            }
            return this;
        }

        calendarEl = document.getElementById('calendar');

        calendar = new FullCalendar.Calendar(calendarEl, {
            plugins: ['timeGrid', 'list', 'interaction'],
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'timeGridWeek,timeGridDay,listWeek,addEventButton'
            },
            defaultDate: '2020-11-02',
            navLinks: true, // can click day/week names to navigate views
            editable: false,
            eventOverlap: false,
            allDaySlot: false,
            eventLimit: true, // allow "more" link when too many events
            eventTimeFormat: {
                hour: '2-digit',
                minute: '2-digit',
                hour12: false,
            },
            slotLabelFormat: {
                hour: '2-digit',
                minute: '2-digit',
                hour12: false,
                omitZeroMinute: false,
            },
            axisFormat: 'H:mm',
            timeFormat: {
                agenda: 'H:mm{ - H:mm}'
            },
            minTime: "08:00:00",
            maxTime: "19:00:00",
        });

        calendar.render();

        $('#developer').trigger('onchange');
    });

    function loadEvents() {

    }

    function loadDeveloper(selectedDeveloperIndex) {
        calendar.removeAllEvents();

        events = [];
        index = 0;

        date = new Date('2020-11-02 09:00');

        for (var i = 0; i < fullData[selectedDeveloperIndex].jobs.length; i++) {
            var remainingHours = fullData[selectedDeveloperIndex].jobs[i].estimated_duration;

            while (remainingHours > 0) {
                var remainingDayHours = endHour - date.getHours();

                events[index] = {};
                events[index].title = fullData[selectedDeveloperIndex].jobs[i].code;
                events[index].start = date.toISOString();

                if (remainingHours < remainingDayHours) {
                    //Gün içinde bitebilecek bir task

                    events[index].end = date.addHours(remainingHours).toISOString();

                    remainingHours -= fullData[selectedDeveloperIndex].jobs[i].estimated_duration;

                    if (date.getHours() == endHour) {
                        date.nextDay();
                    }
                } else {
                    //Günü kapsayacak bir task
                    var hours = endHour - date.getHours();

                    date.setHours(endHour)

                    events[index].end = date.toISOString();

                    remainingHours -= hours;

                    date.nextDay();
                }

                calendar.addEvent(events[index]);

                index++;
            }
        }

        $('#endDate').val(date.toISOString().slice(0, 10) + " " + date.toTimeString().slice(0, 5) + ":00");

        var hours = fullData[selectedDeveloperIndex].totalHours;
        var weeks = parseInt(hours / 45);

        if(hours % 45 != 0 || hours == 0){
            weeks++;
        }

        if(hours == null){
            hours = 0;
        }

        $('#totalHours').val(hours + " Saat / " + weeks + " Hafta");
    }
</script>
</html>
