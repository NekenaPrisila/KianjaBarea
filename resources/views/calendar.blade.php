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
        <div class="search-container">
            <div class="search-header" onclick="toggleSearch()">
                <h5>
                    <i class="fas fa-search me-2"></i>Recherche avancée
                </h5>
                <i class="fas fa-chevron-down search-toggle-icon collapsed"></i>
            </div>
            <div class="search-content" id="searchContent" style="display: none;">
                <form id="search-form" class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">Date</label>
                        <input type="date" id="search-date" class="form-control form-control-sm">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Client</label>
                        <input type="text" id="search-client" class="form-control form-control-sm" placeholder="Nom du client">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Mot-clé</label>
                        <input type="text" id="search-keyword" class="form-control form-control-sm" placeholder="Recherche...">
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <button type="button" class="btn btn-primary btn-sm me-2" onclick="filterEvents()">
                            <i class="fas fa-search me-1"></i> Rechercher
                        </button>
                        <button type="button" class="btn btn-outline-secondary btn-sm" onclick="resetSearch()">
                            <i class="fas fa-sync-alt"></i> Réinitialiser
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Carte du calendrier principal -->
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="card-title mb-0">Calendrier des Réservations</h5>
                    <button class="btn btn-outline-primary btn-sm" onclick="location.href='/reservations/create'">
                        <i class="fas fa-plus me-1"></i> Nouvelle réservation
                    </button>
                </div>

                <!-- Légende -->
                {{-- <div class="resource-legend mb-3">
                    <div class="legend-item">
                        <div class="legend-color bg-reserved"></div>
                        <span>Réservé</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-color bg-available"></div>
                        <span>Disponible</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-color bg-urgent"></div>
                        <span>Urgent</span>
                    </div>
                </div> --}}

                <!-- Calendrier -->
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

    // Utilise directement les événements du contrôleur (ils ont déjà leur couleur)
    const mainCalendarEvents = @json($events);

    // Fonction pour basculer l'affichage de la recherche
    function toggleSearch() {
        const searchContent = document.getElementById('searchContent');
        const toggleIcon = document.querySelector('.search-toggle-icon');
        
        if (searchContent.style.display === 'none') {
            searchContent.style.display = 'block';
            toggleIcon.classList.remove('collapsed');
            toggleIcon.classList.add('expanded');
        } else {
            searchContent.style.display = 'none';
            toggleIcon.classList.remove('expanded');
            toggleIcon.classList.add('collapsed');
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
        filtered.forEach(evt => {
            mainCalendar.addEvent(evt);
        });
    }

    function resetSearch() {
        document.getElementById('search-form').reset();
        mainCalendar.removeAllEvents();
        mainCalendarEvents.forEach(evt => {
            mainCalendar.addEvent(evt);
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        const resources = @json($resources);

        const mainCalendar = new FullCalendar.Calendar(document.getElementById('main-calendar'), {
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
            events: mainCalendarEvents,
            slotMinTime: '08:00:00',
            slotMaxTime: '20:00:00',
            resourceAreaWidth: '150px',
            eventClick: function(info) {
                // Rediriger vers la page de détails de la réservation
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