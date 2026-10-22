
        <header class="header">
            <ul class="header__list">
            <li class="header__list-item"><p>AlToque </p><img src="../imagenes/logo_al_toque.png" alt=""></li>

                <li class="header__list-item">
                    <a class="inicio-link" href="publicar.php">
                        Publicar Servicio
                    </a>
                </li>
                <li class="header__list-item">
                    Bienvenido:
                    <?php echo $_SESSION["cliente"]; ?>
                </li>
                <li class="header__list-item usuario_admin_item">
                    Administrador
                </li>
                <input
                    type="checkbox"
                    class="header__checkbox"
                    id="header__checkbox"
                />
                <label for="header__checkbox" class="header__label">=</label>
                <nav class="header__nav">
                    <ul class="header__nav-list">
                        <li class="header__nav-item">
                            <a class="perfil_link" href="perfil_admin.php">Administración Sistema</a>
                        </li>
                        <li class="header__nav-item">
                            <a class="cerrar_sesion_link" href="../../backend/cerrar_sesion.php"
                                >Cerrar Sesión</a
                            >
                        </li>
                    </ul>
                </nav>
            </ul>
        </header>