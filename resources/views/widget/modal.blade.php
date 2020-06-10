<!-- Modal -->
<div class="modal fade" id="{{ $id }}" tabindex="-1" role="dialog" aria-labelledby="{{ $id }}Label" aria-hidden="true">
    <div class="modal-dialog {{ isset($size) ? 'modal-'.$size : '' }}" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="{{ $id }}Label">{!! $title !!}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @if(isset($form))
                <form action="{{ $form['action'] }}" method="{{ $form['method'] }}" id="{{ $form['id'] }}">
                    <div class="modal-body">
                        @yield ($as . '_body')
                    </div>
                    @if(!isset($footer) || $footer)
                        <div class="modal-footer">
                            @if(!isset($cancelButton) || $cancelButton)
                                <button type="button" class="btn btn-secondary"
                                        data-dismiss="modal">{{ isset($cancelButtonText) ? $cancelButtonText:'ยกเลิก' }}</button>
                            @endif
                            @if(!isset($confirmButton) || $confirmButton)
                                <button type="submit" {{ isset($confirmButtonDisabled) && $confirmButtonDisabled ? 'disabled':'' }} {{ isset($confirmButtonId) && $confirmButtonId ? 'id='.$confirmButtonId:'' }}
                                class="btn btn-primary">{{ isset($confirmButtonText) ? $confirmButtonText :'ยืนยัน' }}</button>
                            @endif
                        </div>
                    @endif
                </form>
            @else
                <div class="modal-body">
                    @yield ($as . '_body')
                </div>
                @if(!isset($footer) || $footer)
                    <div class="modal-footer">
                        @if(!isset($cancelButton) || $cancelButton)
                            <button type="button" class="btn btn-secondary"
                                    data-dismiss="modal">{{ isset($cancelButtonText) ? $cancelButtonText:'ยกเลิก' }}</button>
                        @endif
                        @if(!isset($confirmButton) || $confirmButton)
                            <button type="submit" {{ isset($confirmButtonDisabled) && $confirmButtonDisabled ? 'disabled':'' }} {{ isset($confirmButtonId) && $confirmButtonId ? 'id='.$confirmButtonId:'' }}
                                    class="btn btn-primary">{{ isset($confirmButtonText) ? $confirmButtonText :'ยืนยัน' }}</button>
                        @endif
                    </div>
                @endif
            @endif
        </div>
    </div>
</div>
