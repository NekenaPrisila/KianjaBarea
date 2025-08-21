@extends('layouts.app')

@section('title', 'Calendriers')

@section('styles')
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/fullcalendar-scheduler@5.11.3/main.min.css" rel="stylesheet" />
<link href="{{ asset('css/calendrier.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <!-- Conteneur de recherche -->
        <div class="card mb-3">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="card-title mb-0">Recherche Réservations</h5>
                    <button id="toggleSearchBtn" class="btn btn-outline-primary btn-sm" type="button" onclick="toggleSearch()">
                        <i id="toggleIcon" class="bi bi-dash"></i>
                    </button>
                </div>

                <form id="search-form" class="search-content" style="display: none;">
                    <div class="row mb-3">
                        <label for="search-date" class="col-sm-2 col-form-label">Date</label>
                        <div class="col-sm-10">
                            <input type="date" id="search-date" class="form-control form-control-sm">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="search-client" class="col-sm-2 col-form-label">Client</label>
                        <div class="col-sm-10">
                            <input type="text" id="search-client" class="form-control form-control-sm" placeholder="Nom du client">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="search-keyword" class="col-sm-2 col-form-label">Mot-clé</label>
                        <div class="col-sm-10">
                            <input type="text" id="search-keyword" class="form-control form-control-sm" placeholder="Recherche...">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label">Actions</label>
                        <div class="col-sm-10">
                            <button type="button" class="btn btn-primary me-2" onclick="filterEvents()">
                                <i class="bi bi-search me-1"></i> Rechercher
                            </button>
                            <button type="button" class="btn btn-outline-secondary me-2" onclick="resetSearch()">
                                <i class="bi bi-arrow-repeat"></i> Réinitialiser
                            </button>
                            <a href="{{ route('reservations.create') }}" class="btn btn-success">
                                <i class="bi bi-plus-lg me-1"></i> Nouvelle réservation
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Carte du calendrier principal -->
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-3">Calendrier des Réservations</h5>
                <div id="main-calendar"></div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar-scheduler@5.11.3/main.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/locales/fr.min.js"></script>

<script>
    let mainCalendar;

    const mainCalendarEvents = @json($events);

    function toggleSearch() {
        const searchContent = document.getElementById('search-form');
        const toggleIcon = document.getElementById('toggleIcon');

        if (searchContent.style.display === 'none') {
            searchContent.style.display = 'block';
            toggleIcon.classList.remove('bi-plus');
            toggleIcon.classList.add('bi-dash');
        } else {
            searchContent.style.display = 'none';
            toggleIcon.classList.remove('bi-dash');
            toggleIcon.classList.add('bi-plus');
        }
    }

    function filterEvents() {
        const dateVal = document.getElementById('search-date').value;
        const clientVal = document.getElementById('search-client').value.toLowerCase();
        const keywordVal = document.getElementById('search-keyword').value.toLowerCase();

        const filtered = mainCalendarEvents.filter(event => {
            const matchesDate = dateVal ? event.start.slice(0,10) === dateVal : true;
            const matchesClient = clientVal ? (event.title.toLowerCase().includes(clientVal)) : true;
            const matchesKeyword = keywordVal ? (event.title.toLowerCase().includes(keywordVal)) : true;

            return matchesDate && matchesClient && matchesKeyword;
        });

        mainCalendar.removeAllEvents();
        filtered.forEach(evt => mainCalendar.addEvent(evt));
    }

    function resetSearch() {
        document.getElementById('search-form').reset();
        mainCalendar.removeAllEvents();
        mainCalendarEvents.forEach(evt => mainCalendar.addEvent(evt));
    }

    document.addEventListener('DOMContentLoaded', function() {
        const resources = @json($resources);

        mainCalendar = new FullCalendar.Calendar(document.getElementById('main-calendar'), {
            schedulerLicenseKey: 'GPL-My-Project-Is-Open-Source',
            initialView: 'resourceTimelineDay',
            locale: 'fr',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'resourceTimelineDay,resourceTimelineWeek'
            },
            resourceAreaHeaderContent: 'Ressources',
            resources: resources,
            resourceGroupField: 'group', // ✅ regroupe par type de ressource
            events: mainCalendarEvents,
            slotMinTime: '08:00:00',
            slotMaxTime: '20:00:00',
            resourceAreaWidth: '220px',
            eventClick: function(info) {
                window.location.href = '/reservations/' + info.event.id;
            },
            dateClick: function(info) {
                window.location.href = '/reservations/create?date=' + info.dateStr;
            }
        });

        mainCalendar.render();
    });
</script>
@endsection
