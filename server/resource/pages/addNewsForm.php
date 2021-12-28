
        <main class="mb-4">

<div class="bg-light p-5 mb-4">

    <div class="container">

        <h1>Nova notícia</h1>

    </div>

</div>

<div class="container">

    <form method="POST">

        <div class="mb-3 w-50">

            <label for="titulo" class="form-label">Título</label>

            <input type="text" id="title" name="title" class="form-control" placeholder="Título da notícia" autocomplete="off">

        </div>

        <div class="mb-3 w-50">

            <label for="conteudo" class="form-label">Conteúdo</label>

            <textarea name="content" id="content" cols="30" rows="5" class="form-control" style="resize: none;"></textarea>

        </div>

        <div class="form-group">
      <button type="submit" class="btn btn-success align-content-lg-center">Publicar</button>
    </div>

    </form>

</div>

</main>