@extends('layout')

@section('content')
@php
$dias = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];
@endphp

<div class="mb-5">
    <h2 class="text-3xl font-bold">Registro de horarios por docente</h2>
    <p class="mt-1 text-base-content/70">Agrega materias y sus horarios (máximo 5 materias por docente).</p>
</div>

@if (request('guardado'))
<div role="alert" class="alert alert-success mb-4">
    Horarios guardados correctamente.
</div>
@endif

<div id="horarioRegistroError" class="alert alert-error mb-4 hidden" role="alert"></div>

<div class="space-y-6">
    <div class="card bg-base-100 shadow-xl">
        <div class="card-body space-y-2">
            <label class="label" for="docenteSelect">
                <span class="label-text font-semibold">Docente</span>
            </label>
            <select id="docenteSelect" class="select select-bordered w-full max-w-md" data-registro-base="{{ url('horarios/registro') }}" data-save-url="{{ route('horarios.registro.guardar') }}">
                <option value="">Selecciona un docente...</option>
                @foreach ($docentes as $docente)
                <option value="{{ $docente->id }}" @selected((int) $idDocenteActual===(int) $docente->id)>{{ $docente->nombre_docente }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div id="panelMaterias" class="hidden">
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body space-y-4">
                <div>
                    <label class="label" for="materiaSelect">
                        <span class="label-text font-semibold">Agregar materia</span>
                    </label>
                    <div class="flex flex-wrap gap-2">
                        <select id="materiaSelect" class="select select-bordered w-full max-w-md">
                            <option value="">Selecciona una materia...</option>
                            @foreach ($materias as $materia)
                            <option value="{{ $materia->id }}">{{ $materia->nombre_materia }}</option>
                            @endforeach
                        </select>
                        <button type="button" id="btnAddMateria" class="btn btn-outline">Agregar materia</button>
                    </div>
                </div>

                <div id="itemsRoot" class="space-y-3"></div>

                <div class="flex flex-wrap gap-2 border-t border-base-300 pt-4">
                    <button type="button" id="btnGuardar" class="btn btn-primary">Guardar</button>
                    <a href="{{ route('horarios.index') }}" class="btn btn-ghost">Volver</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    (function() {
        const MAX_MATERIAS = 5;
        const DIAS = @json($dias);
        const docenteSelect = document.getElementById('docenteSelect');
        const materiaSelect = document.getElementById('materiaSelect');
        const btnAddMateria = document.getElementById('btnAddMateria');
        const btnGuardar = document.getElementById('btnGuardar');
        const itemsRoot = document.getElementById('itemsRoot');
        const panelMaterias = document.getElementById('panelMaterias');
        const boxError = document.getElementById('horarioRegistroError');

        let items = @json($itemsPrecargados);

        function showError(msg) {
            if (!boxError) return;
            boxError.textContent = msg;
            boxError.classList.remove('hidden');
        }

        function clearError() {
            if (!boxError) return;
            boxError.textContent = '';
            boxError.classList.add('hidden');
        }

        function syncPanel() {
            const open = Boolean(docenteSelect && docenteSelect.value);
            if (panelMaterias) panelMaterias.classList.toggle('hidden', !open);
        }

        function escHtml(s) {
            return String(s)
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;');
        }

        function pickDiaDisponible(horarios) {
            const usados = (horarios || []).map(function(h) {
                return h.dia;
            });
            for (let i = 0; i < DIAS.length; i++) {
                if (usados.indexOf(DIAS[i]) === -1) return DIAS[i];
            }
            return null;
        }

        function renderItems() {
            if (!itemsRoot) return;
            clearError();
            itemsRoot.innerHTML = items.map(function(item, mIndex) {
                const rows = (item.horarios || []).map(function(horario, hIndex) {
                    const opts = DIAS.map(function(d) {
                        const sel = horario.dia === d ? ' selected' : '';
                        return '<option value="' + d + '"' + sel + '>' + d + '</option>';
                    }).join('');
                    return '<tr>' +
                        '<td class="min-w-40"><select class="select select-bordered select-sm w-full hr-dia" data-m-index="' + mIndex + '" data-h-index="' + hIndex + '">' + opts + '</select></td>' +
                        '<td class="min-w-36"><input type="time" class="input input-bordered input-sm w-full hr-ini" data-m-index="' + mIndex + '" data-h-index="' + hIndex + '" value="' + (horario.hora_inicio || '') + '"></td>' +
                        '<td class="min-w-36"><input type="time" class="input input-bordered input-sm w-full hr-fin" data-m-index="' + mIndex + '" data-h-index="' + hIndex + '" value="' + (horario.hora_fin || '') + '"></td>' +
                        '<td class="w-28"><button type="button" class="btn btn-xs btn-error hr-del" data-m-index="' + mIndex + '" data-h-index="' + hIndex + '">Quitar</button></td>' +
                        '</tr>';
                }).join('');

                return '<div class="card bg-base-200" data-materia-card="' + mIndex + '">' +
                    '<div class="card-body space-y-3">' +
                    '<div class="flex items-start justify-between gap-3">' +
                    '<div class="text-lg font-semibold">Materia: ' + escHtml(item.nombre_materia || '') + '</div>' +
                    '<button type="button" class="btn btn-sm btn-error hr-del-materia" data-m-index="' + mIndex + '">Quitar materia</button>' +
                    '</div>' +
                    '<div class="overflow-x-auto"><table class="table table-sm"><thead><tr><th>Día</th><th>Hora inicio</th><th>Hora fin</th><th></th></tr></thead><tbody>' +
                    rows +
                    '</tbody></table></div>' +
                    '<div><button type="button" class="btn btn-sm btn-outline hr-add" data-m-index="' + mIndex + '">Agregar horario</button></div>' +
                    '</div></div>';
            }).join('');
        }

        function readPayloadFromDom() {
            const out = [];
            for (let m = 0; m < items.length; m++) {
                const copy = {
                    materia_id: items[m].materia_id,
                    nombre_materia: items[m].nombre_materia,
                    horarios: []
                };
                const card = itemsRoot.querySelector('[data-materia-card="' + m + '"]');
                if (!card) continue;
                const diasEl = card.querySelectorAll('.hr-dia');
                const iniEl = card.querySelectorAll('.hr-ini');
                const finEl = card.querySelectorAll('.hr-fin');
                for (let h = 0; h < diasEl.length; h++) {
                    copy.horarios.push({
                        dia: diasEl[h].value,
                        hora_inicio: iniEl[h] ? iniEl[h].value : '',
                        hora_fin: finEl[h] ? finEl[h].value : ''
                    });
                }
                out.push(copy);
            }
            return out;
        }

        if (docenteSelect) {
            docenteSelect.addEventListener('change', function() {
                const id = docenteSelect.value;
                const base = docenteSelect.getAttribute('data-registro-base') || '';
                if (!id) {
                    window.location.href = base;
                    return;
                }
                window.location.href = base.replace(/\/$/, '') + '/' + encodeURIComponent(id);
            });
        }

        if (btnAddMateria) {
            btnAddMateria.addEventListener('click', function() {
                clearError();
                if (!docenteSelect || !docenteSelect.value) {
                    showError('Selecciona un docente primero.');
                    return;
                }
                if (items.length >= MAX_MATERIAS) {
                    showError('No se puede agregar mas de 5 materias por docente.');
                    return;
                }
                const mid = materiaSelect && materiaSelect.value ? parseInt(materiaSelect.value, 10) : 0;
                if (!mid) {
                    showError('Selecciona una materia.');
                    return;
                }
                for (let i = 0; i < items.length; i++) {
                    if (parseInt(items[i].materia_id, 10) === mid) {
                        showError('Esa materia ya fue agregada.');
                        return;
                    }
                }
                const opt = materiaSelect.selectedOptions[0];
                const nombre = opt ? opt.textContent : 'Materia';
                items.push({
                    materia_id: mid,
                    nombre_materia: nombre,
                    horarios: []
                });
                if (materiaSelect) materiaSelect.value = '';
                renderItems();
            });
        }

        if (itemsRoot) {
            itemsRoot.addEventListener('click', function(e) {
                const t = e.target;
                if (!t || !t.closest) return;
                const del = t.closest('.hr-del');
                if (del) {
                    e.preventDefault();
                    clearError();
                    const m = parseInt(del.getAttribute('data-m-index'), 10);
                    const h = parseInt(del.getAttribute('data-h-index'), 10);
                    items = readPayloadFromDom();
                    if (items[m] && items[m].horarios) items[m].horarios.splice(h, 1);
                    renderItems();
                    return;
                }
                const delM = t.closest('.hr-del-materia');
                if (delM) {
                    e.preventDefault();
                    clearError();
                    const m = parseInt(delM.getAttribute('data-m-index'), 10);
                    items = readPayloadFromDom();
                    items.splice(m, 1);
                    renderItems();
                    return;
                }
                const add = t.closest('.hr-add');
                if (add) {
                    e.preventDefault();
                    clearError();
                    const m = parseInt(add.getAttribute('data-m-index'), 10);
                    items = readPayloadFromDom();
                    const dia = pickDiaDisponible(items[m].horarios);
                    if (!dia) {
                        showError('No hay dias disponibles para agregar otro horario en esta materia.');
                        return;
                    }
                    items[m].horarios.push({
                        dia: dia,
                        hora_inicio: '08:00',
                        hora_fin: '09:00'
                    });
                    renderItems();
                }
            });

            itemsRoot.addEventListener('change', function(e) {
                const t = e.target;
                if (!t || !t.classList) return;
                if (t.classList.contains('hr-dia') || t.classList.contains('hr-ini') || t.classList.contains('hr-fin')) {
                    clearError();
                    items = readPayloadFromDom();
                }
            });
            itemsRoot.addEventListener('input', function(e) {
                const t = e.target;
                if (!t || !t.classList) return;
                if (t.classList.contains('hr-ini') || t.classList.contains('hr-fin')) {
                    items = readPayloadFromDom();
                }
            });
        }

        if (btnGuardar) {
            btnGuardar.addEventListener('click', async function() {
                clearError();
                if (!docenteSelect || !docenteSelect.value) {
                    showError('Selecciona un docente.');
                    return;
                }
                items = readPayloadFromDom();
                const docente_id = parseInt(docenteSelect.value, 10);
                const tokenMeta = document.querySelector('meta[name="csrf-token"]');
                const token = tokenMeta ? tokenMeta.getAttribute('content') : '';
                const url = docenteSelect.getAttribute('data-save-url') || '';

                btnGuardar.disabled = true;
                try {
                    const res = await fetch(url, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': token,
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: JSON.stringify({
                            docente_id: docente_id,
                            items: items
                        })
                    });
                    const raw = await res.text();
                    const ct = (res.headers.get('content-type') || '').toLowerCase();
                    let data = null;
                    if (ct.indexOf('application/json') !== -1) {
                        try {
                            data = JSON.parse(raw);
                        } catch (parseErr) {
                            showError('Respuesta JSON inválida (HTTP ' + res.status + '). Primeros caracteres: ' + raw.slice(0, 240));
                            return;
                        }
                    } else {
                        showError('El servidor no devolvió JSON (HTTP ' + res.status + '). Suele pasar con sesión vencida (419) o error 500. Fragmento: ' + raw.replace(/\s+/g, ' ').slice(0, 280));
                        return;
                    }

                    if (!res.ok) {
                        let msg = data.message || ('Error HTTP ' + res.status);
                        if (data.errors && typeof data.errors === 'object') {
                            const parts = [];
                            Object.keys(data.errors).forEach(function(k) {
                                const arr = data.errors[k];
                                if (Array.isArray(arr)) parts.push(arr.join(' '));
                            });
                            if (parts.length) msg = parts.join(' ');
                        }
                        showError(msg);
                        return;
                    }

                    if (data.success && data.redirect) {
                        window.location.assign(data.redirect);
                        return;
                    }
                    showError(data.message || 'Respuesta inesperada del servidor.');
                } catch (err) {
                    showError('Fallo de red o del navegador: ' + (err && err.message ? err.message : String(err)));
                } finally {
                    btnGuardar.disabled = false;
                }
            });
        }

        syncPanel();
        renderItems();
    })();
</script>
@endsection