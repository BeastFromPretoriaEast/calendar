<script src="{{ asset('js/dark-mode-switch.min.js') }}"></script>
<script>
    $(function () {
        $('[data-toggle="popover"]').popover();
    });
</script>

<footer class="footer mt-2 bg-light shadow-lg">
    <div class="container bottom_border">
        <div class="row">
            <div class="col-12 pt-3 pb-3 text-center">
                <small>
                    <img class="logo-bottom mr-2" src="{{ asset('images/logo.png') }}" alt="Calendar Logo"> {{ $year }} Holiday Calendar Ltd.<span class="ml-3 mr-3 op-3">|</span><a href="">Privacy</a><span class="ml-3 mr-3 op-3">|</span><a href="" >Terms & Conditions</a>
                </small>
            </div>
        </div>
    </div>
</footer>
</body>
</html>
