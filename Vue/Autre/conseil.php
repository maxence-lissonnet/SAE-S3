<link rel="stylesheet" href="Asset/style/conseilstyle.css">
<?php require __DIR__ . '/../../Controller/Autre/HeaderController.php'; ?>

<main class="eg-tips-page">

  <section class="eg-tips-hero">
    <div class="eg-tips-hero-left">
      <p class="eg-tips-kicker">Conseils recyclage</p>
      <h1 class="eg-tips-title">Réduire, réemployer, recycler.</h1>
      <p class="eg-tips-subtitle">
        Sur le campus, chaque geste compte. Suis ces conseils pour donner une seconde vie au
        matériel et éviter des kilos de CO<sub>2</sub>.
      </p>
    </div>

    <div class="eg-tips-hero-right">
      <!-- Mets l’image que tu veux ici -->
      <img src="Asset/image/conseil/main.png"
           alt="Objets du quotidien prêts à être recyclés"
           class="eg-tips-main-img">
    </div>
  </section>

  <section class="eg-tips-content">

    <!-- Colonne gauche : texte -->
    <section class="eg-tips-text">

      <h2>Le bon ordre des gestes</h2>
      <ul class="eg-tips-list">
        <li><strong>1. Réemployer d’abord</strong> : en utilisant ce qui existe déjà.</li>
        <li><strong>2. Réparer si possible</strong> : petit bricolage, pièces détachées ou stock.</li>
        <li><strong>3. Recycler en dernier</strong> : tri correct dans les bacs / filières dédiées.</li>
      </ul>

      <h2>Tri rapide</h2>
      <h3>Bac papier / carton</h3>
      <ul class="eg-tips-list">
        <li>Feuilles, cahiers, boîtes propres, prospectus.</li>
        <li>Pas de papier sale, mouchoirs, essuie-tout usagés.</li>
      </ul>

      <h3>Bac plastique / métal</h3>
      <ul class="eg-tips-list">
        <li>Bouteilles, flacons, barquettes propres, canettes.</li>
        <li>Écraser la bouteille, remettre le bouchon.</li>
      </ul>

      <h3>Bac verre</h3>
      <ul class="eg-tips-list">
        <li>Bouteilles, bocaux sans couvercle.</li>
      </ul>

      <h3>Déchets alimentaires</h3>
      <ul class="eg-tips-list">
        <li>Reste de repas, marc de café, filtres papier.</li>
        <li>À déposer dans les bacs à compost (zones identifiées).</li>
      </ul>

      <h3>Non recyclables</h3>
      <ul class="eg-tips-list">
        <li>Films gras, vaisselle cassée, stylos usés (sauf filière dédiée).</li>
      </ul>

      <h2>Bonnes pratiques au quotidien</h2>
      <ul class="eg-tips-list">
        <li>Alléger le tri : vider et rincer rapidement les contenants gras.</li>
        <li>Éviter le jetable : gourde, mug réutilisable, couverts durables.</li>
        <li>Impressions raisonnées : recto–verso, noir et blanc, se relire avant d’imprimer.</li>
        <li>Achats responsables : privilégier l’occasion via ÉcoGestUM avant d’acheter neuf.</li>
        <li>Énergie : éteindre les écrans / prises le soir, mode veille courte.</li>
      </ul>

      <h2>Erreurs fréquentes (à éviter)</h2>
      <ul class="eg-tips-list">
        <li>Jeter gobelets souillés, essuie-tout ou boîtes pizza grasses dans le bac papier.</li>
        <li>Déposer appareils électroniques dans le bac plastique.</li>
        <li>Mettre verre dans le bac plastique/métal (verre = colonne dédiée).</li>
        <li>Laisser piles/batteries dans les tiroirs : risque d’échauffement ou d’incendie.</li>
      </ul>

    </section>

    <!-- Colonne droite : pictos / rappel tri -->
    <aside class="eg-tips-side">
      <div class="eg-tips-card">
        <h3>À retenir</h3>
        <ul class="eg-tips-list">
          <li><strong>Un déchet bien trié</strong> = une matière réutilisable.</li>
          <li>Les consignes peuvent changer : vérifier les affiches sur les bornes.</li>
          <li>En cas de doute, utiliser la FAQ ou contacter le Service Environnement.</li>
        </ul>
      </div>

      <div class="eg-tips-logos">
        <!-- remplace les src par tes vraies images si tu en as -->
        <img src="Asset/image/conseil/tri.png" alt="Pictogramme réemploi">
       
      </div>
    </aside>

  </section>

</main>

<?php require __DIR__ . '/../Header Footer/footer.php'; ?> 
</body>
</html>
