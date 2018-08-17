<form class="form" action="/submit" method="post">
    <input type="hidden" name="stage" value="3">

    <div class="form-group">
        <label>Select day of week:</label>

        <select class="form-control" name="dayOfWeek">
            @foreach($allowedDaysOfWeek as $day)
                <option value="{{ $day }}">{{ $day }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label>Start time:</label>

        <select class="form-control" name="startTime" required>
            @for($i = 9; $i < 19; $i++)
                <option value="{{ $i }}">{{ $i . ':00' }}</option>
            @endfor
        </select>
    </div>

    <div class="form-group">
        <label>End time:</label>

        <select class="form-control" name="endTime" required>
            @for($i = 10; $i <= 19; $i++)
                <option value="{{ $i }}">{{ $i . ':00' }}</option>
            @endfor
        </select>
    </div>

    <div class="form-group">
        <label>Amount of weeks:</label>

        <input class="form-control" type="text" name="weekCount" required>
    </div>

    <div class="form-group text-right">
        <button class="btn btn-primary">Next ></button>
    </div>
</form>