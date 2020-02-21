<div class="col-md-12">
    <div class="blog-post">
        <ul class="pag" id="pag">
            <?php

            for ($i = 0; $i < $totalCount; $i++) : ?>

                <li class="posts-pagination ml-2 btn btn-secondary" data-limit="<?= $i ?>"><?= $i + 1 ?></li>


            <?php endfor; ?>
        </ul>
    </div>
</div>