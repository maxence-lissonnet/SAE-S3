<footer class="eg-footer">
  <div class="eg-footer-main">
    
    <!-- Colonne gauche : logo + adresse + gros boutons -->
    <div class="eg-footer-col eg-footer-left">
      <div class="eg-footer-logo-block">
        <img src="../../Asset/image/footer/univbl.png" alt="Le Mans Université" class="eg-footer-logo">
        <div class="eg-footer-uni-name">
        </div>
      </div>

      <p class="eg-footer-address">
        9 rue Olivier Messiaen<br>
        72085 Le Mans Cedex 9
      </p>

      <div class="eg-footer-buttons">
        <a href="tel:0243833000" class="eg-footer-btn">
          <span class="eg-footer-btn-icon">📞</span>
          <span>02 43 83 30 00</span>
        </a>
        <a href="#" class="eg-footer-btn">
          <span class="eg-footer-btn-icon">✉️</span>
          <span>Nous contacter</span>
        </a>
        <a href="#" class="eg-footer-btn">
          <span class="eg-footer-btn-icon">📍</span>
          <span>Plan des campus</span>
        </a>
      </div>
    </div>

    <!-- Colonne centre : liens rapides -->
    <div class="eg-footer-col eg-footer-middle">
      <h3 class="eg-footer-title">Accès rapide</h3>
      <ul class="eg-footer-links">
        <li><a href="#">Tous nos sites web</a></li>
        <li><a href="#">Espace presse</a></li>
        <li><a href="#">Offres d’emploi</a></li>
        <li><a href="#">Marchés publics</a></li>
        <li><a href="#">Charte graphique</a></li>
      </ul>
    </div>

    <!-- Colonne droite : réseaux + bouton politique -->
    <div class="eg-footer-col eg-footer-right">
      <h3 class="eg-footer-title">Restons connectés</h3>

      <div class="eg-footer-socials">
        <a href="#" aria-label="Instagram">
          <img src="Asset/image/footer/Logo Instagram.png" alt="Instagram">
        </a>
        <a href="#" aria-label="LinkedIn">
          <img src="Asset/image/footer/Logo LinkedIn.png" alt="LinkedIn">
        </a>
        <a href="#" aria-label="YouTube">
          <img src="Asset/image/footer/Logo YT.png" alt="YouTube">
        </a>
        <a href="#" aria-label="Facebook">
          <img src="Asset/image/footer/Logo Facebook.png" alt="Facebook">
        </a>
      </div>

      <a href="politique.php" class="eg-footer-btn eg-footer-btn-secondary">
        Politique de recyclage
      </a>
    </div>

  </div>

  <!-- Barre tout en bas -->
  <div class="eg-footer-bottom">
    <a href="#">Accessibilité</a>
    <a href="#">Données personnelles</a>
    <a href="#">Mentions légales</a>
    <a href="#">Plan du site</a>
  </div>
</footer>
<!-- Pop-up de confirmation -->
<div id="confirmationPopup" class="eg-popup" style="display: none;">
  <div class="eg-popup-content">
    <div class="eg-popup-header">
      <span id="popupTitle" class="eg-popup-title">Confirmer l'action</span>
      <button id="closePopup" class="eg-popup-close">X</button>
    </div>
    <div class="eg-popup-body">
      <p id="popupMessage">Êtes-vous sûr de vouloir effectuer cette action ?</p>
    </div>
    <div class="eg-popup-footer">
      <button id="confirmAction" class="eg-btn-main">OUI</button>
      <button id="cancelAction" class="eg-btn-secondary">NON</button>
    </div>
  </div>
</div>

<script src="Asset/style/popup.js"></script>
</body>
</html>
