function downloadPDF() {
    // Sélectionne l'élément conteneur
    const element = document.getElementById('report-container');

    // Options de configuration pour html2pdf
    const opt = {
        margin: 10,
        filename: 'rapport_activite.pdf',
        image: { type: 'jpeg', quality: 0.98 },
        html2canvas: { scale: 2 },
        jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
    };

    // Génération
    html2pdf().set(opt).from(element).save();
}
