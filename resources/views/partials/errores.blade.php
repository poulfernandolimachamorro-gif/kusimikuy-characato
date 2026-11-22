{{-- Bloque reutilizable: lista los errores de validación (en español) de un formulario --}}
@if ($errors->any())
    <div role="alert" style="background: rgba(239, 68, 68, 0.1); border-left: 4px solid #ef4444; color: #fca5a5; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem;">
        <strong><i class="fa-solid fa-triangle-exclamation"></i> Revise los siguientes datos:</strong>
        <ul style="margin: 0.5rem 0 0 0; padding-left: 1.5rem; list-style-type: disc;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif