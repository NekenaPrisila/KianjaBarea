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
                <h5 class="card-title">Répartition mensuelle des chiffres d'affaire en {{ $anneeSelectionnee }}</h5>

                <!-- Bar Chart -->
                <canvas id="chiffreChart" height="130"></canvas>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
{{-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> --}}

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const ctx = document.getElementById('chiffreChart').getContext('2d');

        const labels = @json($mois);
        const data = @json($chiffre);

        const monthNames = ['Jan', 'Fév', 'Mars', 'Avril', 'Mai', 'Juin', 'Juil', 'Août', 'Sept', 'Oct', 'Nov', 'Déc'];
        const formattedLabels = labels.map(m => monthNames[parseInt(m) - 1]);

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: formattedLabels,
                datasets: [{
                    label: 'Chiffre d\'affaire',
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
                            text: 'Chiffre d\'affaire'
                        },
                        ticks: {
                            stepSize: 10000000,
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
    });
</script>
@endsection
