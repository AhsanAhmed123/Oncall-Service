@extends('layouts.layout')

@section('content')
</br>
</br>
</br>
</br>
</br>
<div class="page-content-wrapper container">
<!-- Left Panel -->
<div class="container">
    <div class="row">
        <div class="col-md-6">
    <div class="tab-div">
        <div class="tabs">
            @foreach($departments as $department)
                <div class="tab" onclick="showDetails({{ $department->id }})">
                    {{ $department->name }}
                </div>
            @endforeach
        </div>
    </div>
    </div>
<div class="col-md-6">
    <div id="details-container" >
        <h2>Details</h2>
        <div id="details-content">
        </div>
    </div>
</div>
    </div>
</div>

<style>
    .container {
        padding: 20px;
    }

    .tab-div {
        background-color: #ffffff;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        padding: 20px;
        margin-bottom: 20px;
    }

    .tabs {
        display: math;
        gap: 10px;
    }

    .tab {
        padding: 18px 20px;
        cursor: pointer;
        border: 1px solid #ddd;
        border-radius: 4px;
        background-color: #f9f9f9;
        transition: background-color 0.3s ease, transform 0.2s ease;
        font-weight: 500;
        color: #333;
    }

    .tab:hover {
        background-color: #e0e0e0;
        transform: translateY(-2px);
    }

    .tab.active {
        background-color: #007bff;
        color: #fff;
        border-color: #007bff;
    }

    #details-container {
        margin-top: 20px;
        padding: 20px;
        background-color: #ffffff;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    #details-content {
        margin-top: 10px;
    }
</style>

<script>
    let selectedTab = null;

    function showDetails(departmentId) {
    if (selectedTab) {
        selectedTab.classList.remove('active');
    }
    const clickedTab = event.currentTarget;
    clickedTab.classList.add('active');
    selectedTab = clickedTab;

    $.ajax({
        url: `/departments/${departmentId}/users`,
        method: 'GET',
        success: function (details) {
            $('#details-content').html(details.view);

            $('#department_id').val(departmentId);
            
            // Draggable functionality ko dubara initialize karein
            initDraggable();
        },
        error: function (xhr, status, error) {
            console.error('Error fetching department details:', error);
        }
    });
}

function initDraggable() {
    const list = document.getElementById("draggableList");

    if (!list) return; // Agar list na mile toh kuch mat karo

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
}

document.addEventListener("DOMContentLoaded", function () {
    initDraggable();
});

</script>

@endsection