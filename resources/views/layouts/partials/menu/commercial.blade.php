<ul class="sidebar-nav" id="sidebar-nav">
    <li class="nav-item">
        <a class="nav-link" href="/calendar">
            <i class="bi bi-speedometer2"></i><span>Dashboard</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#reservation-nav" data-bs-toggle="collapse">
            <i class="bi bi-calendar-check"></i><span>Réservations</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="reservation-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
            <li><a href="/reservations/create"><i class="bi bi-plus-circle"></i><span>Ajout</span></a></li>
            <li><a href="/reservations"><i class="bi bi-list-ul"></i><span>Liste</span></a></li>
        </ul>
    </li>

    <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#client-nav" data-bs-toggle="collapse">
            <i class="bi bi-people"></i><span>Clients</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="client-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
            <li><a href="/clients/create"><i class="bi bi-person-plus"></i><span>Ajout</span></a></li>
            <li><a href="/clients"><i class="bi bi-list-ul"></i><span>Liste</span></a></li>
        </ul>
    </li>

    <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#ressource-nav" data-bs-toggle="collapse">
            <i class="bi bi-box-seam"></i><span>Ressources</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="ressource-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
            <li><a href="/ressources/create"><i class="bi bi-plus-circle"></i><span>Ajout</span></a></li>
            <li><a href="/ressources"><i class="bi bi-list-ul"></i><span>Liste</span></a></li>
        </ul>
    </li>

    <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#facture-nav" data-bs-toggle="collapse">
            <i class="bi bi-file-earmark-text"></i><span>Factures</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="facture-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
            <li><a href="/factures"><i class="bi bi-list-ul"></i><span>Liste</span></a></li>
        </ul>
    </li>
</ul>
