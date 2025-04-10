<div>
<form action="{{ route('saveOncallPeopleOrder') }}" method="POST">
    @csrf
    <div class="form-group">
        <input type="hidden" name="department_id" id="department_id">
        <label for="timeBetweenAttempts">Time Between Attempts</label>
        <input type="text" id="timeBetweenAttempts" name="time" value="{{$backupPeople[0]->time??'' }}" required class="form-control">
    </div>

    <div class="form-group row">
        <div class="col-md-6">
                <label>Backup People</label>
            <ul id="backupPeopleList" class="list-group">
                @foreach ($backupPeople as $index => $person)
                    <div value="{{$person->users->id}}" style="color: white; margin-top: 10px; border-radius: 5px; width: 250px; background-color: black; padding: 10px;">
                        {{ $person->users->name }}
                    </div>    
                @endforeach
            </ul>
        </div>

        

        <div class="col-md-6">
            <label>Oncall People Available</label>
            <br>
            <ul id="draggableList">
                @foreach ($oncallPeople as $index => $person)
                    <li draggable="true" id="item-{{ $person->id }}" data-id="{{ $person->id }}" style="background-color: black;padding: 7px;border-radius: 5px;color: white;width: 226px; margin-bottom: 6px;">
                        {{ $person->name }} 
                        <button type="button" onclick="removeItem({{ $person->id }})">remove</button>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    <input type="hidden" name="oncall_order" id="oncallOrder">
    <button type="submit" class="btn btn-primary">Save</button>
</form>


</div>

<script>
    const list = document.getElementById("draggableList");

    list.addEventListener("dragstart", (event) => {
        event.dataTransfer.setData("text/plain", event.target.dataset.id);
    });

    list.addEventListener("dragover", (event) => {
        event.preventDefault();
    });

    list.addEventListener("drop", (event) => {
        event.preventDefault();
        const draggedId = event.dataTransfer.getData("text/plain");
        const draggedElement = document.querySelector(`[data-id='${draggedId}']`);
        const dropTarget = event.target.closest("li");

        if (dropTarget && dropTarget !== draggedElement) {
            list.insertBefore(draggedElement, dropTarget.nextSibling);
            updateOrder();
        }
    });

    function updateOrder() {
        let order = [];
        document.querySelectorAll("#draggableList li").forEach((li, index) => {
            order.push({ id: li.dataset.id, position: index + 1 });
        });
        document.getElementById("oncallOrder").value = JSON.stringify(order);
    }

    function removeItem(id) {
        document.querySelector(`[data-id='${id}']`).remove();
        updateOrder();
    }
</script>