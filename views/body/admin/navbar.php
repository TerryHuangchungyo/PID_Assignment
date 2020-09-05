<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <a class="navbar-brand" href="<?=$data["navBrand"]["link"]?>"><?=$data["navBrand"]["value"]?></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav">
            <?php foreach( $data["navListLHS"] as $link => $value ):?>
                <li class="nav-item <?=($data["pageName"] == $value)?"active":""?>">
                    <a class="nav-link" href="<?=$link?>"><?=$value?></a>
                </li>
            <?php endforeach; ?>
        </ul>
        <ul class="ml-auto navbar-nav">
            <?php foreach( $data["navListRHS"] as $link => $value ):?>
                <li class="nav-item <?=($data["pageName"] == $value)?"active":""?>">
                    <a class="nav-link" href="<?=$link?>"><?=$value?></a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</nav>