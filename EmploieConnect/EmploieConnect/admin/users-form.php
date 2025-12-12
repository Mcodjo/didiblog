                <?php if ($action === 'create' || $action === 'edit'): ?>
                <!-- Formulaire de création/édition -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">
                            <i class="fas <?= $action === 'create' ? 'fa-plus' : 'fa-edit' ?> mr-2 text-orange-500"></i>
                            <?= $action === 'create' ? 'Nouvel Utilisateur' : 'Modifier l\'Utilisateur' ?>
                        </h2>
                    </div>

                    <form method="POST" class="p-6">
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <!-- Username -->
                            <div>
                                <label for="username" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    <i class="fas fa-user mr-2 text-orange-500"></i>Nom d'utilisateur *
                                </label>
                                <input type="text" id="username" name="username" required
                                       value="<?= $action === 'edit' && isset($editUser) ? escape($editUser['username']) : '' ?>"
                                       class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                                       placeholder="Nom d'utilisateur unique">
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    <i class="fas fa-envelope mr-2 text-orange-500"></i>Email *
                                </label>
                                <input type="email" id="email" name="email" required
                                       value="<?= $action === 'edit' && isset($editUser) ? escape($editUser['email']) : '' ?>"
                                       class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                                       placeholder="adresse@email.com">
                            </div>

                            <!-- Mot de passe -->
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    <i class="fas fa-lock mr-2 text-orange-500"></i>Mot de passe <?= $action === 'create' ? '*' : '(laisser vide pour ne pas changer)' ?>
                                </label>
                                <input type="password" id="password" name="password" <?= $action === 'create' ? 'required' : '' ?>
                                       class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                                       placeholder="Mot de passe sécurisé">
                            </div>

                            <!-- Rôle -->
                            <div>
                                <label for="role" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    <i class="fas fa-user-shield mr-2 text-orange-500"></i>Rôle
                                </label>
                                <select id="role" name="role"
                                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                                    <option value="user" <?= $action === 'edit' && isset($editUser) && $editUser['role'] === 'user' ? 'selected' : '' ?>>Utilisateur</option>
                                    <option value="admin" <?= $action === 'edit' && isset($editUser) && $editUser['role'] === 'admin' ? 'selected' : '' ?>>Administrateur</option>
                                </select>
                            </div>

                            <!-- Prénom -->
                            <div>
                                <label for="first_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    <i class="fas fa-id-card mr-2 text-orange-500"></i>Prénom
                                </label>
                                <input type="text" id="first_name" name="first_name"
                                       value="<?= $action === 'edit' && isset($editUser) ? escape($editUser['first_name']) : '' ?>"
                                       class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                                       placeholder="Prénom">
                            </div>

                            <!-- Nom -->
                            <div>
                                <label for="last_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    <i class="fas fa-id-card mr-2 text-orange-500"></i>Nom
                                </label>
                                <input type="text" id="last_name" name="last_name"
                                       value="<?= $action === 'edit' && isset($editUser) ? escape($editUser['last_name']) : '' ?>"
                                       class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                                       placeholder="Nom de famille">
                            </div>

                            <!-- Téléphone -->
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    <i class="fas fa-phone mr-2 text-orange-500"></i>Téléphone
                                </label>
                                <input type="tel" id="phone" name="phone"
                                       value="<?= $action === 'edit' && isset($editUser) ? escape($editUser['phone']) : '' ?>"
                                       class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                                       placeholder="+229 66 68 34 87">
                            </div>

                            <!-- Statut actif -->
                            <div class="flex items-center">
                                <input type="checkbox" id="actif" name="actif" value="1" 
                                       <?= $action === 'create' || ($action === 'edit' && isset($editUser) && $editUser['actif']) ? 'checked' : '' ?>
                                       class="h-4 w-4 text-orange-600 focus:ring-orange-500 border-gray-300 rounded">
                                <label for="actif" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                                    <i class="fas fa-toggle-on mr-2 text-orange-500"></i>Compte actif
                                </label>
                            </div>
                        </div>

                        <!-- Bio -->
                        <div class="mt-6">
                            <label for="bio" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                <i class="fas fa-align-left mr-2 text-orange-500"></i>Biographie
                            </label>
                            <textarea id="bio" name="bio" rows="4"
                                      class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                                      placeholder="Description de l'utilisateur..."><?= $action === 'edit' && isset($editUser) ? escape($editUser['bio']) : '' ?></textarea>
                        </div>

                        <!-- Boutons -->
                        <div class="flex items-center justify-between pt-6 border-t border-gray-200 dark:border-gray-700 mt-6">
                            <a href="<?= SITE_URL ?>/admin/users.php" 
                               class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-lg transition-colors">
                                <i class="fas fa-arrow-left mr-2"></i>Retour
                            </a>
                            <button type="submit" 
                                    class="bg-orange-600 hover:bg-orange-700 text-white px-6 py-3 rounded-lg transition-colors">
                                <i class="fas fa-save mr-2"></i>
                                <?= $action === 'create' ? 'Créer l\'utilisateur' : 'Mettre à jour' ?>
                            </button>
                        </div>
                    </form>
                </div>
                <?php endif; ?>
            </main>
        </div>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('show');
        }

        // Fermer la sidebar en cliquant en dehors (mobile)
        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('sidebar');
            const isClickInsideSidebar = sidebar.contains(event.target);
            const isClickOnToggle = event.target.closest('button[onclick="toggleSidebar()"]');
            
            if (!isClickInsideSidebar && !isClickOnToggle && window.innerWidth < 1024) {
                sidebar.classList.remove('show');
            }
        });
    </script>
</body>
</html>
