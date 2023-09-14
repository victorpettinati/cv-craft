<script>
        // Compteur pour le numéro de l'expérience
        let experienceCount = 1;

        // Fonction pour ajouter un groupe de champs d'expérience
        function ajouterExperience() {
            experienceCount++;
            
            // Créer des nouveaux champs pour une nouvelle expérience
            const newExperience = document.createElement('div');
            newExperience.innerHTML = `
                <h2>Expérience ${experienceCount}</h2>
                <label for="titre_poste_${experienceCount}">Titre du poste :</label>
                <input type="text" id="titre_poste_${experienceCount}" name="titre_poste[]" required><br>

                <label for="date_debut_${experienceCount}">Date de début :</label>
                <input type="date" id="date_debut_${experienceCount}" name="date_debut[]" required><br>

                <label for="date_fin_${experienceCount}">Date de fin :</label>
                <input type="date" id="date_fin_${experienceCount}" name="date_fin[]" required><br>

                <label for="entreprise_${experienceCount}">Entreprise :</label>
                <input type="text" id="entreprise_${experienceCount}" name="entreprise[]" required><br>

                <label for="detail_poste_${experienceCount}">Détail du poste :</label>
                <textarea id="detail_poste_${experienceCount}" name="detail_poste[]" required></textarea><br>
                
                <!-- Bouton pour supprimer cette expérience -->
                <button type="button" onclick="supprimerExperience(${experienceCount})">Supprimer</button>
            `;

            // Ajouter les nouveaux champs à la fin du formulaire
            document.querySelector('form').appendChild(newExperience);
        }

        // Fonction pour supprimer un groupe de champs d'expérience
        function supprimerExperience(experienceId) {
            // Trouver l'élément parent (div) de l'expérience à supprimer
            const experienceDiv = document.getElementById(`titre_poste_${experienceId}`).closest('div');
            
            // Supprimer l'expérience de l'interface utilisateur
            experienceDiv.remove();
        }

        // Écouteur d'événement pour le bouton "Ajouter une expérience"
        document.getElementById('ajouter_experience').addEventListener('click', ajouterExperience);
    </script>