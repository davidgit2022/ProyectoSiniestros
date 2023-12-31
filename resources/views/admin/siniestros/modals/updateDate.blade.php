<div class="modal" tabindex="-1" id="theModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Actualizar Fecha</h5>
                <button type="button" id="btnClose" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="javascript:void(0)" id="formUpdateDate" method="POST"
                enctype="application/x-www-form-urlencoded">
                @csrf 
                <div class="modal-body">
                    <input type="hidden" name="siniestroId" id="siniestroId" value="">

                    <div class="mb-3">
                        <label>Taller:</label>
                        <select class="form-control" name="taller_modal" id="taller_modal" autofocus">
                            <option value="">Seleccionar</option>
                            @foreach ($workshops as $workshop)
                                <option value="{{ $workshop->id }}">{{ $workshop->name }}</option>
                            @endforeach
                        </select>
                        <span class="error-message text-danger" id="tallerError"></span>
                    </div>
                    <div class="mb-3">
                        <label for="newDate" class="form-label">Fecha Nueva</label>
                        <input type="date" class="form-control" name="newDate" id="newDate">
                        <span class="error-message text-danger" id="newDateError"></span>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Comentarios</label>
                        <textarea class="form-control" name="comment" id="comment" rows="5"></textarea>
                        <span class="error-message text-danger" id="commentError"></span>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="cancelButton">Cerrar</button>
                    <button type="submit" class="btn btn-primary" id="btnActualizar" onclick="guardarDatos()">Actualizar</button>
                </div>
            </form>
        </div>
    </div>
</div>

