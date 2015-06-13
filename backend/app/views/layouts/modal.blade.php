<div class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            
            @if (isset($title))
                <div class="modal-header">
                    <button type="button" class="close" ng-click="$hide()">
                        <span aria-hidden="true">&times;</span>
                        <span class="sr-only">Close</span>
                    </button>
                    <h4 class="modal-title">{{ $title }}</h4>
                </div>
            @endif
            
            <div class="modal-body">
                @yield('body')                
            </div>
            
            <div class="modal-footer">
                @yield('footer')
            </div>
            
        </div>
    </div>
</div>