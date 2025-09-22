@extends('layouts.app')

@section('title', 'Statistiques des Réservations')

@section('content')
<div class="row mb-3">
    <div class="col-3">
        <form method="GET" action="{{ url()->current() }}">
            <label for="annee" class="form-label">Filtrer par année :</label>
            <select name="annee" id="annee" class="form-select" onchange="this.form.submit()">
                @foreach ($anneesDisponibles as $annee)
                    <option value="{{ $annee }}" @if($annee == $anneeSelectionnee) selected @endif>{{ $annee }}</option>
                @endforeach
            </select>
        </form>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Répartition mensuelle des réservations en {{ $anneeSelectionnee }}</h5>

                <!-- Bar Chart -->
                <canvas id="reservationsChart" height="130"></canvas>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.3.0/dist/chart.umd.min.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Guards and helpful console logs to debug why the chart may not render
        if (typeof Chart === 'undefined') {
            console.error('Chart.js is not loaded. Ensure the CDN script is reachable.');
            return;
        }

        const canvas = document.getElementById('reservationsChart');
        if (!canvas) {
            console.error('Canvas element with id "reservationsChart" not found in DOM.');
            return;
        }

        const ctx = canvas.getContext('2d');

        // Ensure server-provided variables are present and are arrays
        const labels = @json($mois ?? []);
        const data = @json($nombre ?? []);

        console.debug('Diagramme - labels:', labels);
        console.debug('Diagramme - data:', data);

        const monthNames = ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Août', 'Sept', 'Oct', 'Nov', 'Déc'];
        const formattedLabels = labels.map(m => {
            const idx = parseInt(m, 10) - 1;
            return monthNames[idx] || m;
        });

        try {
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: formattedLabels,
                    datasets: [{
                        label: 'Nombre de réservations',
                        data: data,
                        backgroundColor: 'rgba(54, 162, 235, 0.5)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Nombre de réservations'
                            },
                            ticks: {
                                stepSize: 1,
                                precision: 0
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Mois'
                            }
                        }
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return `Réservations: ${context.raw}`;
                                }
                            }
                        }
                    }
                }
            });
        } catch (err) {
            console.error('Erreur à la création du Chart:', err);
        }
    });
</script>
@endsection
