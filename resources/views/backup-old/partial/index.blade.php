<div>
    <form action="" method="POST">
        
        <div class="form-group">
            <label for="timeBetweenAttempts">Time Between Attempts</label>
            <input type="hidden" name="departmentId" >
            <input type="text" id="timeBetweenAttempts" name="timeBetweenAttempts" class="form-control" >
        </div>

        <div class="form-group">
            <label for="backupOrder">Backup Order</label>
            <input type="text" id="backupOrder" name="backupOrder" class="form-control" value="">
        </div>

        <div class="form-group">
            <label for="backupPeople">Backup People</label>
            <ul id="backupPeopleList" class="list-group">
                @foreach ($backupPeople as $index => $person)
                    <li class="list-group-item d-flex justify-content-between align-items-center" data-id="{{ $index }}">
                        {{ $person }}
                        <button type="button" class="btn btn-danger btn-sm remove-person" data-id="{{ $index }}">Remove</button>
                    </li>
                @endforeach
            </ul>
        </div>

        

        <button type="submit" class="btn btn-primary">Save</button>
    </form>
</div>
