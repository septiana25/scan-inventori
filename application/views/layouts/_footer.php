<div></div>
<footer>
    <nav class="container">
        <div class="row row-cols-4">
            <div class="col btnMenu">
                <button onclick="window.location.href='<?= base_url(); ?>'">
                    <div class="btnIcon">
                        <i class="fa fa-home" aria-hidden="true"></i>
                    </div>
                    <p>Home</p>
                </button>
            </div>
            <div class="col btnMenu">
                <button onclick="window.location.href='<?= base_url('masuk/index'); ?>'">
                    <div class="btnIcon">
                        <i class="fa fa-reply" aria-hidden="true"></i>
                    </div>
                    <p>Masuk</p>
                </button>

            </div>
            <div class="col btnMenu">
                <button onclick="window.location.href='<?= base_url('keluar/index'); ?>'">
                    <div class="btnIcon">
                        <i class="fa fa-share" aria-hidden="true"></i>
                    </div>
                    <p>Keluar</p>
                </button>

            </div>
            <div class="col btnMenu">
                <button onclick="window.location.href='<?= base_url('profile'); ?>'">
                    <div class="btnIcon">
                        <i class="fa fa-user" aria-hidden="true"></i>
                    </div>
                    <p>Profile</p>
                </button>

            </div>
        </div>
    </nav>
</footer>