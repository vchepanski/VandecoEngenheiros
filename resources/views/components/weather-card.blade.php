<div class="border-0 shadow-sm card" style="width: 250px; background: linear-gradient(135deg, #f0f9ff, #e0f2fe);">
    <div class="p-3 card-body">
        <h5 class="mb-1 text-dark">
            <i class="fas fa-cloud-sun text-primary me-1"></i> {{ $data['city'] ?? 'Cidade' }}
        </h5>
        <p class="mb-0 text-muted small">{{ $data['description'] }}</p>

        <h3 class="my-2 fw-bold text-primary">{{ $data['temperature'] }}°C</h3>

        <div class="text-center d-flex justify-content-between">
            <div>
                <i class="fas fa-tint text-info"></i>
                <div class="small">{{ $data['humidity'] }}%</div>
            </div>
            <div>
                <i class="fas fa-wind text-secondary"></i>
                <div class="small">{{ $data['wind_speed'] }} m/s</div>
            </div>
            <div>
                <i class="fas fa-clock text-success"></i>
                <div class="small">
                    {{ now()->setTimezone('America/Sao_Paulo')->format('H:i') }}
                </div>
            </div>
        </div>
    </div>
</div>
