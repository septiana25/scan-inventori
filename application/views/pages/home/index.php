
        <main class="container">
            <section id="form">
            <?php $this->load->view('layouts/_alert')?>
                <form action="#">
                    <div class="mb-3">
                      <label for="userName" class="form-label">Username</label>
                      <input type="text" class="form-control" id="userName" placeholder="Masukan Nama User">
                    </div>
                    <div class="mb-3">
                      <label for="password" class="form-label">Password</label>
                      <input type="password" class="form-control" id="password" placeholder="Masukan Password">
                    </div>
                    <button type="submit" class="btn btn-primary">Login</button>
                  </form>
            </section>
        </main>

