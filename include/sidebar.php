<?php

function desktopSidebar($activeMenu): void
{
    ?>
    <div class="sidebar d-none d-lg-block">
        <nav class="header-nav d-flex flex-column justify-content-between">
            <ul>
                <li class="nav-item <?php if ($activeMenu === 'dashboard.php') echo 'active'; ?>">
                    <a href="../dashboard.php" class="nav-link">
                        <div style="fill: #000000" class="img-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="ionicon img-icon" viewBox="0 0 512 512">
                                <path d="M326.1 231.9l-47.5 75.5a31 31 0 01-7 7 30.11 30.11 0 01-35-49l75.5-47.5a10.23 10.23 0 0111.7 0 10.06 10.06 0 012.3 14z"/>
                                <path d="M256 64C132.3 64 32 164.2 32 287.9a223.18 223.18 0 0056.3 148.5c1.1 1.2 2.1 2.4 3.2 3.5a25.19 25.19 0 0037.1-.1 173.13 173.13 0 01254.8 0 25.19 25.19 0 0037.1.1l3.2-3.5A223.18 223.18 0 00480 287.9C480 164.2 379.7 64 256 64z"
                                      fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                      stroke-width="32"/>
                                <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-miterlimit="10"
                                      stroke-width="32"
                                      d="M256 128v32M416 288h-32M128 288H96M165.49 197.49l-22.63-22.63M346.51 197.49l22.63-22.63"/>
                            </svg>
                        </div>
                        Dashboard
                    </a>
                </li>

                <li class="nav-item <?php if ($activeMenu === 'persons.php') echo 'active'; ?>">
                    <a href="../persons.php?page=1" class="nav-link">
                        <div style="fill: #000000" class="img-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="ionicon" viewBox="0 0 512 512">
                                <path d="M402 168c-2.93 40.67-33.1 72-66 72s-63.12-31.32-66-72c-3-42.31 26.37-72 66-72s69 30.46 66 72z"
                                      fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                      stroke-width="32"/>
                                <path d="M336 304c-65.17 0-127.84 32.37-143.54 95.41-2.08 8.34 3.15 16.59 11.72 16.59h263.65c8.57 0 13.77-8.25 11.72-16.59C463.85 335.36 401.18 304 336 304z"
                                      fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32"/>
                                <path d="M200 185.94c-2.34 32.48-26.72 58.06-53 58.06s-50.7-25.57-53-58.06C91.61 152.15 115.34 128 147 128s55.39 24.77 53 57.94z"
                                      fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                      stroke-width="32"/>
                                <path d="M206 306c-18.05-8.27-37.93-11.45-59-11.45-52 0-102.1 25.85-114.65 76.2-1.65 6.66 2.53 13.25 9.37 13.25H154"
                                      fill="none" stroke="currentColor" stroke-linecap="round" stroke-miterlimit="10"
                                      stroke-width="32"/>
                            </svg>
                        </div>
                        Persons
                    </a>
                </li>
                <li class="nav-item <?php if ($activeMenu === 'jobs.php') echo 'active'; ?>">
                    <a href="../jobs.php" class="nav-link">
                        <div style="fill: #000000" class="img-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="ionicon" viewBox="0 0 512 512">
                                <rect x="32" y="128" width="448" height="320" rx="48" ry="48" fill="none"
                                      stroke=#015d98 stroke-linejoin="round" stroke-width="32"/>
                                <path d="M144 128V96a32 32 0 0132-32h160a32 32 0 0132 32v32M480 240H32M320 240v24a8 8 0 01-8 8H200a8 8 0 01-8-8v-24"
                                      fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                      stroke-width="32"/>
                            </svg>
                        </div>
                        Jobs
                    </a>
                </li>
                <li class="nav-title fourth-heading">My account</li>
                <li>
                    <ul>
                        <li class="nav-item <?php if ($activeMenu === 'my-profile.php') echo 'active'; ?>">
                            <a href="../my-profile.php" class="nav-link active">
                                <div style="fill: #000000" class="img-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="ionicon" viewBox="0 0 512 512">
                                        <path d="M384 224v184a40 40 0 01-40 40H104a40 40 0 01-40-40V168a40 40 0 0140-40h167.48"
                                              fill="none" stroke="currentColor" stroke-linecap="round"
                                              stroke-linejoin="round" stroke-width="32"/>
                                        <path d="M459.94 53.25a16.06 16.06 0 00-23.22-.56L424.35 65a8 8 0 000 11.31l11.34 11.32a8 8 0 0011.34 0l12.06-12c6.1-6.09 6.67-16.01.85-22.38zM399.34 90L218.82 270.2a9 9 0 00-2.31 3.93L208.16 299a3.91 3.91 0 004.86 4.86l24.85-8.35a9 9 0 003.93-2.31L422 112.66a9 9 0 000-12.66l-9.95-10a9 9 0 00-12.71 0z"/>
                                    </svg>
                                </div>
                                Edit profile
                            </a>
                        </li>
                        <li class="nav-item">
                            <div class="wrapper">
                                <a href="../action/action-logout.php" class="nav-link active">
                                    <div style="fill: #000000" class="img-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="ionicon" viewBox="0 0 512 512">
                                            <path d="M304 336v40a40 40 0 01-40 40H104a40 40 0 01-40-40V136a40 40 0 0140-40h152c22.09 0 48 17.91 48 40v40M368 336l80-80-80-80M176 256h256"
                                                  fill="none" stroke="currentColor" stroke-linecap="round"
                                                  stroke-linejoin="round" stroke-width="32"/>
                                        </svg>
                                    </div>
                                    Log out
                                </a>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>

        </nav>
    </div>
    <?php
}

function mobileSidebar($activeMenu): void
{
    ?>
    <nav class="header-nav d-flex align-items-center">
        <div class="offcanvas offcanvas-start" data-bs-scroll="true" data-bs-backdrop="false" tabindex="-1"
             id="offcanvasScrolling" aria-labelledby="offcanvasScrollingLabel">
            <div class="offcanvas-header">
                <h3 class="offcanvas-title third-heading sidebar-heading" id="offcanvasScrollingLabel">
                    <a href="../dashboard.php" id="logo">
                        <img src="../assets/properties/pma-color.png" alt="PerMap logo" class="logo"/>
                    </a>
                </h3>

                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body d-flex flex-column justify-content-between py-0 px-0">
                <div class="offcanvas-body">
                    <ul>
                        <li class="nav-item <?php if ($activeMenu === 'dashboard.php') echo 'active'; ?>">
                            <a href="../dashboard.php" class="nav-link">
                                <div style="fill: #000000" class="img-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="ionicon img-icon"
                                         viewBox="0 0 512 512">
                                        <path d="M326.1 231.9l-47.5 75.5a31 31 0 01-7 7 30.11 30.11 0 01-35-49l75.5-47.5a10.23 10.23 0 0111.7 0 10.06 10.06 0 012.3 14z"/>
                                        <path d="M256 64C132.3 64 32 164.2 32 287.9a223.18 223.18 0 0056.3 148.5c1.1 1.2 2.1 2.4 3.2 3.5a25.19 25.19 0 0037.1-.1 173.13 173.13 0 01254.8 0 25.19 25.19 0 0037.1.1l3.2-3.5A223.18 223.18 0 00480 287.9C480 164.2 379.7 64 256 64z"
                                              fill="none" stroke="currentColor" stroke-linecap="round"
                                              stroke-linejoin="round"
                                              stroke-width="32"/>
                                        <path fill="none" stroke="currentColor" stroke-linecap="round"
                                              stroke-miterlimit="10"
                                              stroke-width="32"
                                              d="M256 128v32M416 288h-32M128 288H96M165.49 197.49l-22.63-22.63M346.51 197.49l22.63-22.63"/>
                                    </svg>
                                </div>
                                Dashboard

                            </a>
                        </li>

                        <li class="nav-item <?php if ($activeMenu === 'persons.php') echo 'active'; ?>">
                            <a href="../persons.php?page=1" class="nav-link">
                                <div style="fill: #000000" class="img-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="ionicon" viewBox="0 0 512 512">
                                        <path d="M402 168c-2.93 40.67-33.1 72-66 72s-63.12-31.32-66-72c-3-42.31 26.37-72 66-72s69 30.46 66 72z"
                                              fill="none" stroke="currentColor" stroke-linecap="round"
                                              stroke-linejoin="round"
                                              stroke-width="32"/>
                                        <path d="M336 304c-65.17 0-127.84 32.37-143.54 95.41-2.08 8.34 3.15 16.59 11.72 16.59h263.65c8.57 0 13.77-8.25 11.72-16.59C463.85 335.36 401.18 304 336 304z"
                                              fill="none" stroke="currentColor" stroke-miterlimit="10"
                                              stroke-width="32"/>
                                        <path d="M200 185.94c-2.34 32.48-26.72 58.06-53 58.06s-50.7-25.57-53-58.06C91.61 152.15 115.34 128 147 128s55.39 24.77 53 57.94z"
                                              fill="none" stroke="currentColor" stroke-linecap="round"
                                              stroke-linejoin="round"
                                              stroke-width="32"/>
                                        <path d="M206 306c-18.05-8.27-37.93-11.45-59-11.45-52 0-102.1 25.85-114.65 76.2-1.65 6.66 2.53 13.25 9.37 13.25H154"
                                              fill="none" stroke="currentColor" stroke-linecap="round"
                                              stroke-miterlimit="10"
                                              stroke-width="32"/>
                                    </svg>
                                </div>
                                Persons
                            </a>
                        </li>
                        <li class="nav-item <?php if ($activeMenu === 'jobs.php') echo 'active'; ?>">
                            <a href="../jobs.php" class="nav-link">
                                <div style="fill: #000000" class="img-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="ionicon" viewBox="0 0 512 512">
                                        <rect x="32" y="128" width="448" height="320" rx="48" ry="48" fill="none"
                                              stroke=#015d98 stroke-linejoin="round" stroke-width="32"/>
                                        <path d="M144 128V96a32 32 0 0132-32h160a32 32 0 0132 32v32M480 240H32M320 240v24a8 8 0 01-8 8H200a8 8 0 01-8-8v-24"
                                              fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                              stroke-width="32"/>
                                    </svg>
                                </div>
                                Jobs
                            </a>
                        </li>
                        <li class="nav-title fourth-heading">My account</li>
                        <li>
                            <ul>
                                <li class="nav-item">
                                    <a href="../my-profile.php" class="nav-link">
                                        <div style="fill: #000000" class="img-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="ionicon"
                                                 viewBox="0 0 512 512">
                                                <path d="M384 224v184a40 40 0 01-40 40H104a40 40 0 01-40-40V168a40 40 0 0140-40h167.48"
                                                      fill="none" stroke="currentColor" stroke-linecap="round"
                                                      stroke-linejoin="round" stroke-width="32"/>
                                                <path d="M459.94 53.25a16.06 16.06 0 00-23.22-.56L424.35 65a8 8 0 000 11.31l11.34 11.32a8 8 0 0011.34 0l12.06-12c6.1-6.09 6.67-16.01.85-22.38zM399.34 90L218.82 270.2a9 9 0 00-2.31 3.93L208.16 299a3.91 3.91 0 004.86 4.86l24.85-8.35a9 9 0 003.93-2.31L422 112.66a9 9 0 000-12.66l-9.95-10a9 9 0 00-12.71 0z"/>
                                            </svg>
                                        </div>
                                        Edit profile
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="../action/action-logout.php" class="nav-link">
                                        <div style="fill: #000000" class="img-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="ionicon"
                                                 viewBox="0 0 512 512">
                                                <path d="M304 336v40a40 40 0 01-40 40H104a40 40 0 01-40-40V136a40 40 0 0140-40h152c22.09 0 48 17.91 48 40v40M368 336l80-80-80-80M176 256h256"
                                                      fill="none" stroke="currentColor" stroke-linecap="round"
                                                      stroke-linejoin="round" stroke-width="32"/>
                                            </svg>
                                        </div>
                                        Log out
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <?php
}