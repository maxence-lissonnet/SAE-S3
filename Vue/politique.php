<?php
// Vue/politique.php
// Page purement statique pour l’instant
?>
<link rel="stylesheet" href="../Asset/style/politiquestyle.css">
<?php require __DIR__ . '/Header Footer/header.php'; ?>

<main class="eg-policy-page">

  <h1 class="eg-policy-title">
    Politique de Recyclage de l’Université du Mans
  </h1>

  <!-- ================= INTRO ================= -->
  <section class="eg-policy-section">
    <h2>Introduction &amp; Objectifs</h2>

    <h3>Contexte et enjeux</h3>
    <ul class="eg-policy-list">
      <li>Le campus génère en moyenne 250 tonnes de déchets par an.</li>
      <li>Objectif&nbsp;: réduire ces volumes de 30% d’ici 2028.</li>
      <li>Valoriser les ressources et sensibiliser la communauté universitaire.</li>
    </ul>

    <h3>Engagement</h3>
    <ul class="eg-policy-list">
      <li>Signature de la charte «&nbsp;Campus Zéro Déchet&nbsp;».</li>
      <li>Collaboration avec la collectivité locale et les centres de traitement agréés.</li>
    </ul>
  </section>

  <!-- ================= PRINCIPES GÉNÉRAUX ================= -->
  <section class="eg-policy-section">
    <h2>Principes Généraux</h2>

    <h3>Filières de recyclage</h3>
    <ul class="eg-policy-list">
      <li>Papier/Carton (bac bleu)</li>
      <li>Verre (bac vert)</li>
      <li>Plastique (bac jaune)</li>
      <li>Déchets électroniques (points R.O.E.E.).</li>
    </ul>

    <h3>Responsabilités</h3>
    <ul class="eg-policy-list">
      <li>Étudiants&nbsp;: trier avant dépôt et rapporter les gobelets réutilisables.</li>
      <li>Personnel&nbsp;: veiller à la disponibilité des bornes et informer de tout incident.</li>
      <li>Services Techniques&nbsp;: assurer le vidage hebdomadaire et la maintenance.</li>
    </ul>

    <h3>Cadre réglementaire</h3>
    <p>
      Conformité aux directives européennes 2018/852 et lois françaises sur l’économie circulaire.
    </p>
  </section>

  <!-- ================= PROCESSUS ================= -->
  <section class="eg-policy-section">
    <h2>Processus de Recyclage</h2>

    <h3>Collecte</h3>
    <ul class="eg-policy-list">
      <li>120 bornes installées sur trois zones&nbsp;: campus nord, résidence, bibliothèque.</li>
      <li>Horaires d’accès&nbsp;: 8h–20h en semaine, 10h–18h le week-end.</li>
    </ul>

    <h3>Tri</h3>
    <ul class="eg-policy-list">
      <li>Consignes affichées sur chaque borne (pictogrammes et codes couleurs).</li>
    </ul>

    <h3>Transport &amp; Traitement</h3>
    <ul class="eg-policy-list">
      <li>Enlèvements&nbsp;: papier/carton et verre chaque lundi, plastique chaque jeudi.</li>
      <li>Partenaire agréé&nbsp;: EcoTri 72 pour le centre de valorisation.</li>
    </ul>

    <h3>Réutilisation</h3>
    <ul class="eg-policy-list">
      <li>Dons&nbsp;: matériel informatique reconditionné offert aux associations étudiantes.</li>
      <li>Bibliothèque&nbsp;: collecte annuelle de manuels pour remise en circulation.</li>
    </ul>
  </section>

  <!-- ================= BONNES PRATIQUES ================= -->
  <section class="eg-policy-section">
    <h2>Bonnes Pratiques</h2>
    <ul class="eg-policy-list">
      <li>Vider et rincer les contenants pour éviter les mauvaises odeurs.</li>
      <li>Séparer les matériaux selon les consignes pour éviter la contamination.</li>
      <li>Participer aux ateliers trimestriels de sensibilisation (dates annoncées sur l’intranet).</li>
      <li>Privilégier le tri connecté&nbsp;: scanner le QR code pour accéder aux tutoriels vidéos.</li>
    </ul>
  </section>

  <!-- ================= FAQ ================= -->
  <section class="eg-policy-section eg-policy-faq">
    <h2>FAQ – Questions Fréquentes</h2>

    <!-- Le champ de recherche pourra servir plus tard avec du JS -->
    <input
      type="text"
      id="faqSearch"
      class="eg-faq-search"
      placeholder="Rechercher une question..."
    >

    <div class="eg-faq-list">

      <article class="eg-faq-item">
        <div class="eg-faq-question-row">
          <span class="eg-faq-question">Que faire des déchets électroniques ?</span>
        </div>
        <div class="eg-faq-answer">
          <p>
            Les appareils électroniques (PC, écrans, téléphones) doivent être déposés
            dans les points R.O.E.E. indiqués sur le plan du campus ou auprès du service
            informatique.
          </p>
        </div>
      </article>

      <article class="eg-faq-item">
        <div class="eg-faq-question-row">
          <span class="eg-faq-question">Où déposer les piles usagées ?</span>
        </div>
        <div class="eg-faq-answer">
          <p>
            Des boîtes à piles sont disponibles à l’accueil des bâtiments principaux
            (bibliothèque, RU, bâtiment Droit &amp; Éco).
          </p>
        </div>
      </article>

      <article class="eg-faq-item">
        <div class="eg-faq-question-row">
          <span class="eg-faq-question">Comment signaler une borne pleine ou défectueuse ?</span>
        </div>
        <div class="eg-faq-answer">
          <p>
            Utilisez le formulaire de signalement sur ÉcoGestUM ou envoyez un mail
            à <a href="mailto:logistique@univ-lemans.fr">logistique@univ-lemans.fr</a>.
          </p>
        </div>
      </article>

      <article class="eg-faq-item">
        <div class="eg-faq-question-row">
          <span class="eg-faq-question">Puis-je proposer une opération de don ?</span>
        </div>
        <div class="eg-faq-answer">
          <p>
            Oui, via le Service Vie Étudiante&nbsp;: votre projet sera étudié pour s’assurer
            de sa conformité à la charte développement durable.
          </p>
        </div>
      </article>

      <article class="eg-faq-item">
        <div class="eg-faq-question-row">
          <span class="eg-faq-question">Comment suivre mes contributions au recyclage ?</span>
        </div>
        <div class="eg-faq-answer">
          <p>
            Les statistiques globales sont publiées chaque trimestre sur ÉcoGestUM
            et affichées dans les halls principaux.
          </p>
        </div>
      </article>

    </div>
  </section>

  <!-- ================= RESSOURCES ================= -->
  <section class="eg-policy-section">
    <h2>Ressources &amp; Liens Utiles</h2>

    <ul class="eg-policy-links">
      <li>
        <a href="#">Guide PDF « Procédure de Tri et Recyclage » (téléchargement direct).</a>
      </li>
      <li>
        <a href="#">Fiches pratiques par matériau (infographies).</a>
      </li>
      <li>
        <a href="#">Tutoriels vidéo sur la chaîne YouTube « UM Recyclage ».</a>
      </li>
      <li>
        Contacts&nbsp;:
        <strong>Service Environnement</strong> :
        <a href="mailto:environnement@univ-lemans.fr">environnement@univ-lemans.fr</a>,<br>
        <strong>Services Techniques</strong> :
        <a href="mailto:logistique@univ-lemans.fr">logistique@univ-lemans.fr</a>,
        tél. 02 43 83 40 00
      </li>
    </ul>
  </section>

  <!-- ================= HISTORIQUE ================= -->
  <section class="eg-policy-section">
    <h2>Historique &amp; Rapports</h2>

    <h3>Rapports disponibles :</h3>
    <ul class="eg-policy-list">
      <li>Rapport Annuel 2024&nbsp;: 45 t recyclées, 12% de réduction de déchets.</li>
      <li>Rapport Trimestriel T3 2025&nbsp;: 12 t recyclées, 7% de réduction.</li>
    </ul>
  </section>

  <!-- ================= CONTACT ================= -->
  <section class="eg-policy-section">
    <h2>Contact &amp; Assistance</h2>
    <p>
      Formulaire de question rapide pour toute demande complémentaire via l’ENT.<br>
      FAQ avancée disponible sur l’intranet.<br>
      Médiation en cas de litige via la plateforme «&nbsp;Support Étudiant&nbsp;».
    </p>
  </section>

</main>

<?php require __DIR__ . '/Header Footer/footer.php'; ?>
</body>
</html>
