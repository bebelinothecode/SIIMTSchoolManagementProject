<div class="sidebar hidden sm:block w-0 sm:w-1/6 bg-gray-200 h-screen shadow fixed top-0 left-0 bottom-0 z-40 overflow-y-auto">
    <div class="mb-6 mt-20 px-6">
        <a href="{{ route('home') }}" 
            class="flex items-center text-gray-600 py-2 hover:text-blue-700"
            aria-label="Dashboard">
            <svg class="h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path d="M3 3h7v7H3zm11 0h7v7h-7zm0 11h7v7h-7zM3 14h7v7H3z"/>
            </svg>
            <span class="ml-2 text-sm font-semibold">Dashboard</span>
        </a>
        @hasrole('Admin|rector|StudCoordinator')
        <div>
            <a href="#"
                class="flex items-center text-gray-600 py-2 hover:text-blue-700"
                onclick="toggleSubMenu101('librarySubmenu11', 'libraryIcon11')"
                aria-expanded="false"
                aria-controls="librarySubmenu11">
                    <svg class="h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512">
                        <path fill="currentColor" d="M320 32c-8.1 0-16.1 1.4-23.7 4.1L15.8 137.4C6.3 140.9 0 149.9 0 160s6.3 19.1 15.8 22.6l57.9 20.9C57.3 229.3 48 259.8 48 291.9v28.1c0 28.4-10.8 57.7-22.3 80.8c-6.5 13-13.9 25.8-22.5 37.6C0 442.7-.9 448.3 .9 453.4s6 8.9 11.2 10.2l64 16c4.2 1.1 8.7 .3 12.4-2s6.3-6.1 7.1-10.4c8.6-42.8 4.3-81.2-2.1-108.7C90.3 344.3 86 329.8 80 316.5V291.9c0-30.2 10.2-58.7 27.9-81.5c12.9-15.5 29.6-28 49.2-35.7l157-61.7c8.2-3.2 17.5 .8 20.7 9s-.8 17.5-9 20.7l-157 61.7c-12.4 4.9-23.3 12.4-32.2 21.6l159.6 57.6c7.6 2.7 15.6 4.1 23.7 4.1s16.1-1.4 23.7-4.1L624.2 182.6c9.5-3.4 15.8-12.5 15.8-22.6s-6.3-19.1-15.8-22.6L343.7 36.1C336.1 33.4 328.1 32 320 32zM128 408c0 35.3 86 72 192 72s192-36.7 192-72L496.7 262.6 354.5 314c-11.1 4-22.8 6-34.5 6s-23.5-2-34.5-6L143.3 262.6 128 408z"/>
                    </svg>
                    <span class="ml-2">Education</span>
                    <svg id="libraryIcon11" class="ml-auto h-4 w-4 transform transition-transform duration-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
            </a>
            <div id="librarySubmenu11" class="hidden pl-6 mt-2">
                <!-- Level 1 Submenu -->
                <div>
                    <a href="{{ route('classes.index') }}" class="flex items-center text-gray-600 py-2 hover:text-blue-700">
                        <svg class="h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                            <path fill="currentColor" d="M96 0C43 0 0 43 0 96V416c0 53 43 96 96 96H384h32c17.7 0 32-14.3 32-32s-14.3-32-32-32V384c17.7 0 32-14.3 32-32V32c0-17.7-14.3-32-32-32H384 96zm0 384H352v64H96c-17.7 0-32-14.3-32-32s14.3-32 32-32zm32-240c0-8.8 7.2-16 16-16H336c8.8 0 16 7.2 16 16s-7.2 16-16 16H144c-8.8 0-16-7.2-16-16zm16 48H336c8.8 0 16 7.2 16 16s-7.2 16-16 16H144c-8.8 0-16-7.2-16-16s7.2-16 16-16z"/>
                        </svg>
                        <span class="ml-2 text-sm font-semibold">Subjects</span>
                    </a>
                    <a href="{{ route('subject.index') }}"
                    class="flex items-center text-gray-600 py-2 hover:text-blue-700"
                    >
                        <svg class="h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512">
                            <path fill="currentColor" d="M320 32c-8.1 0-16.1 1.4-23.7 4.1L15.8 137.4C6.3 140.9 0 149.9 0 160s6.3 19.1 15.8 22.6l57.9 20.9C57.3 229.3 48 259.8 48 291.9v28.1c0 28.4-10.8 57.7-22.3 80.8c-6.5 13-13.9 25.8-22.5 37.6C0 442.7-.9 448.3 .9 453.4s6 8.9 11.2 10.2l64 16c4.2 1.1 8.7 .3 12.4-2s6.3-6.1 7.1-10.4c8.6-42.8 4.3-81.2-2.1-108.7C90.3 344.3 86 329.8 80 316.5V291.9c0-30.2 10.2-58.7 27.9-81.5c12.9-15.5 29.6-28 49.2-35.7l157-61.7c8.2-3.2 17.5 .8 20.7 9s-.8 17.5-9 20.7l-157 61.7c-12.4 4.9-23.3 12.4-32.2 21.6l159.6 57.6c7.6 2.7 15.6 4.1 23.7 4.1s16.1-1.4 23.7-4.1L624.2 182.6c9.5-3.4 15.8-12.5 15.8-22.6s-6.3-19.1-15.8-22.6L343.7 36.1C336.1 33.4 328.1 32 320 32zM128 408c0 35.3 86 72 192 72s192-36.7 192-72L496.7 262.6 354.5 314c-11.1 4-22.8 6-34.5 6s-23.5-2-34.5-6L143.3 262.6 128 408z"/>
                        </svg>
                        <span class="ml-2 text-sm font-semibold">Academic</span>
                    </a>
                    <a href="{{ route('diploma.index') }}"
                    class="flex items-center text-gray-600 py-2 hover:text-blue-700"
                    >
                        <svg class="h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                            <path fill="currentColor" d="M528 160V416c0 8.8-7.2 16-16 16H320c0-44.2-35.8-80-80-80H176c-44.2 0-80 35.8-80 80H64c-8.8 0-16-7.2-16-16V160H528zM64 32C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H512c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H64zM272 256a64 64 0 1 1 128 0 64 64 0 1 1 -128 0zm104-80a24 24 0 1 1 0 48 24 24 0 1 1 0-48z"/>
                        </svg>
                        <span class="ml-2 text-sm font-semibold">Professional</span>
                    </a>
                </div>
            </div>
        </div>
        
        <script>
            function toggleSubMenu101(submenuId, iconId) {
                event.preventDefault();
                const submenu = document.getElementById(submenuId);
                const icon = document.getElementById(iconId);
                
                // Toggle the submenu visibility
                submenu.classList.toggle('hidden');
                
                // Rotate the icon
                if (submenu.classList.contains('hidden')) {
                    icon.classList.remove('rotate-180');
                } else {
                    icon.classList.add('rotate-180');
                }
            }
        </script>

        <div>
            <a href="#"
            class="flex items-center text-gray-600 py-2 hover:text-blue-700"
            onclick="toggleSubMenu('librarySubmenu', 'libraryIcon')">
                <svg class="h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                    <path fill="currentColor" d="M224 256c70.7 0 128-57.3 128-128S294.7 0 224 0 96 57.3 96 128s57.3 128 128 128zm89.6 32h-16.7c-22.2 10.2-46.9 16-72.9 16s-50.6-5.8-72.9-16h-16.7C60.2 288 0 348.2 0 422.4V464c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48v-41.6c0-74.2-60.2-134.4-134.4-134.4z"/>
                </svg>
                <span class="ml-2">Student</span>
                <svg id="libraryIcon" class="ml-auto h-4 w-4 transform transition-transform duration-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </a>
            <div id="librarySubmenu" class="hidden pl-6 mt-2">
                <!-- Level 1 Submenu -->
                <div>
                    <a href="{{ route('student.index') }}"
                    class="flex items-center text-gray-600 py-2 hover:text-blue-700"
                    >
                        <svg class="h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                            <path fill="currentColor" d="M288 0H128v128h160V0zM128 256h160V128H128V256zM288 128h160V0H288V128zM128 384h160V256H128V384zM288 256h160V128H288V256zM128 512h160V384H128V512zM288 384h160V256H288V384z"/>
                        </svg>
                        <span class="ml-2 text-sm font-semibold">Student List</span>
                    </a>
                    <a href="#"
                    class="flex items-center text-gray-600 py-2 hover:text-blue-700"
                    >
                        <svg class="h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                            <path fill="currentColor" d="M96 0C43 0 0 43 0 96V416c0 53 43 96 96 96H384h32c17.7 0 32-14.3 32-32s-14.3-32-32-32V384c17.7 0 32-14.3 32-32V32c0-17.7-14.3-32-32-32H384 96zm0 384H352v64H96c-17.7 0-32-14.3-32-32s14.3-32 32-32zm32-240c0-8.8 7.2-16 16-16H336c8.8 0 16 7.2 16 16s-7.2 16-16 16H144c-8.8 0-16-7.2-16-16zm16 48H336c8.8 0 16 7.2 16 16s-7.2 16-16 16H144c-8.8 0-16-7.2-16-16s7.2-16 16-16z"/>
                        </svg>
                        <span class="ml-2 text-sm font-semibold">Course Registration</span>
                    </a>
                    <a href="https://form.jotform.com/250754187639569"
                    class="flex items-center text-gray-600 py-2 hover:text-blue-700"
                    target="_blank"
                    >
                        <svg class="h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                            <path fill="currentColor" d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"/>
                        </svg>
                        <span class="ml-2 text-sm font-semibold">Lecturer Evaluation</span>
                    </a>
                    <a href="#"
                    class="flex items-center text-gray-600 py-2 hover:text-blue-700"
                    onclick="toggleSubMenu('academicSubmenu', 'academicIcon')">
                        <svg class="h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512">
                            <path fill="currentColor" d="M64 0C28.7 0 0 28.7 0 64V448c0 35.3 28.7 64 64 64H320c35.3 0 64-28.7 64-64V160H256c-17.7 0-32-14.3-32-32V0H64zM256 0V128H384L256 0zM80 64h64c8.8 0 16 7.2 16 16s-7.2 16-16 16H80c-8.8 0-16-7.2-16-16s7.2-16 16-16zm0 64h64c8.8 0 16 7.2 16 16s-7.2 16-16 16H80c-8.8 0-16-7.2-16-16s7.2-16 16-16zm16 96H288c17.7 0 32 14.3 32 32v64c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V256c0-17.7 14.3-32 32-32zm0 32v64H288V256H96zM240 416h64c8.8 0 16 7.2 16 16s-7.2 16-16 16H240c-8.8 0-16-7.2-16-16s7.2-16 16-16z"/>
                        </svg>
                        <span class="ml-2 text-sm font-semibold">Document Request</span>
                        <svg id="academicIcon" class="ml-auto h-4 w-4 transform transition-transform duration-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </a>
                    <!-- Level 2 Submenu -->
                    <div id="academicSubmenu" class="hidden pl-4 mt-2">
                        <div>
                            <a href="#"
                            class="flex items-center text-gray-600 py-2 hover:text-blue-700"
                            onclick="toggleSubMenu('scienceSubmenu', 'scienceIcon')">
                                <svg class="h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                    <path fill="currentColor" d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM232 344V280H168c-13.3 0-24-10.7-24-24s10.7-24 24-24h64V168c0-13.3 10.7-24 24-24s24 10.7 24 24v64h64c13.3 0 24 10.7 24 24s-10.7 24-24 24H280v64c0 13.3-10.7 24-24 24s-24-10.7-24-24z"/>
                                </svg>
                                <span class="ml-2 text-sm">Introduction Letter</span>
                            </a>
                            <a href="#"
                            class="flex items-center text-gray-600 py-2 hover:text-blue-700"
                            onclick="toggleSubMenu('scienceSubmenu', 'scienceIcon')">
                                <svg class="h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                    <path fill="currentColor" d="M336 352c97.2 0 176-78.8 176-176S433.2 0 336 0S160 78.8 160 176c0 18.7 2.9 36.8 8.3 53.7L7 391c-4.5 4.5-7 10.6-7 17v80c0 13.3 10.7 24 24 24h80c13.3 0 24-10.7 24-24V448h40c13.3 0 24-10.7 24-24V384h40c6.4 0 12.5-2.5 17-7l33.3-33.3c16.9 5.4 35 8.3 53.7 8.3zM376 96a40 40 0 1 1 0 80 40 40 0 1 1 0-80z"/>
                                </svg>
                                <span class="ml-2 text-sm">Immigration Letter</span>
                            </a>
                            <a href="#"
                            class="flex items-center text-gray-600 py-2 hover:text-blue-700"
                            onclick="toggleSubMenu('scienceSubmenu', 'scienceIcon')">
                                <svg class="h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                    <path fill="currentColor" d="M168.5 72L256 165l87.5-93h-175zM383.9 99.1L311.5 176h129L383.9 99.1zm50 124.9H256 78.1L256 420.3 433.9 224zM71.5 176h129L128.1 99.1 71.5 176zm434.3 40.1l-232 256c-4.5 5-11 7.9-17.8 7.9s-13.2-2.9-17.8-7.9l-232-256c-4.5-5-7.8-11.7-7.9-19.8C.7 190.7 8.3 176 24 176H488c15.7 0 23.3 14.7 15.9 24.9-1.1 8.1-3.4 14.8-7.9 19.8z"/>
                                </svg>
                                <span class="ml-2 text-sm">Recommendation Letter</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <script>
        function toggleSubMenu444(submenuId, iconId) {
            event.preventDefault();
            const submenu = document.getElementById(submenuId);
            const icon = document.getElementById(iconId);
            
            // Toggle the submenu visibility
            submenu.classList.toggle('hidden');
            
            // Rotate the icon
            if (submenu.classList.contains('hidden')) {
                icon.classList.remove('rotate-180');
            } else {
                icon.classList.add('rotate-180');
            }
        }
        </script>

    <script>
        function toggleSubMenu(submenuId, iconId) {
            event.preventDefault();
            const submenu = document.getElementById(submenuId);
            const icon = document.getElementById(iconId);
            
            // Toggle the submenu visibility
            submenu.classList.toggle('hidden');
            
            // Rotate the icon
            if (submenu.classList.contains('hidden')) {
                icon.classList.remove('rotate-180');
            } else {
                icon.classList.add('rotate-180');
            }
        }
    </script>
        
        <style>
        .rotate-180 {
            transform: rotate(180deg);
        }
        </style>

        <div>
            <a href="#"
            class="flex items-center text-gray-600 py-2 hover:text-blue-700"
            onclick="toggleSubMenu1('librarySubmenu1', 'libraryIcon1')">
                <svg class="h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                    <path fill="currentColor" d="M512 80c8.8 0 16 7.2 16 16v32H48V96c0-8.8 7.2-16 16-16H512zm16 144V416c0 8.8-7.2 16-16 16H64c-8.8 0-16-7.2-16-16V224H528zM64 32C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H512c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H64zm56 304c-13.3 0-24 10.7-24 24s10.7 24 24 24h48c13.3 0 24-10.7 24-24s-10.7-24-24-24H120zm128 0c-13.3 0-24 10.7-24 24s10.7 24 24 24h48c13.3 0 24-10.7 24-24s-10.7-24-24-24H248z"/>
                </svg>
                <span class="ml-2">Account & Finance</span>
                <svg id="libraryIcon1" class="ml-auto h-4 w-4 transform transition-transform duration-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </a>
            <div id="librarySubmenu1" class="hidden pl-6 mt-2">
                <!-- Level 1 Submenu -->
                <div>
                    <a href="{{ route('get.transactions') }}" class="flex items-center text-gray-600 py-2 hover:text-blue-700">
                        <svg class="h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                            <path fill="currentColor" d="M64 64C28.7 64 0 92.7 0 128V384c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V128c0-35.3-28.7-64-64-64H64zm64 112c0-8.8 7.2-16 16-16h32c8.8 0 16 7.2 16 16v32c0 8.8-7.2 16-16 16H144c-8.8 0-16-7.2-16-16V176zm112 16h32c8.8 0 16-7.2 16-16V176c0-8.8-7.2-16-16-16H240c-8.8 0-16 7.2-16 16v32c0 8.8 7.2 16 16 16zm-80 80c0-8.8 7.2-16 16-16h32c8.8 0 16 7.2 16 16v32c0 8.8-7.2 16-16 16H144c-8.8 0-16-7.2-16-16V272zm112 16h32c8.8 0 16-7.2 16-16V272c0-8.8-7.2-16-16-16H240c-8.8 0-16 7.2-16 16v32c0 8.8 7.2 16 16 16zm144-48c0 8.8-7.2 16-16 16H368c-8.8 0-16-7.2-16-16V176c0-8.8 7.2-16 16-16h32c8.8 0 16 7.2 16 16v32z"/>
                        </svg>
                        <span class="ml-2 text-sm font-semibold">Transactions</span>
                    </a>
                    <a href="{{route('fees.defaulters')}}"
                    class="flex items-center text-gray-600 py-2 hover:text-blue-700">
                        <svg class="h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                            <path fill="currentColor" d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zm0-384c13.3 0 24 10.7 24 24V264c0 13.3-10.7 24-24 24s-24-10.7-24-24V152c0-13.3 10.7-24 24-24zM224 352a32 32 0 1 1 64 0 32 32 0 1 1 -64 0z"/>
                        </svg>
                        <span class="ml-2 text-sm font-semibold">Defaulters</span>
                    </a>
                    <a href="{{ route('expenses.table') }}" class="flex items-center text-gray-600 py-2 hover:text-blue-700">
                        <svg class="h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512">
                            <path fill="currentColor" d="M64 464c-8.8 0-16-7.2-16-16V64c0-8.8 7.2-16 16-16H224v80c0 17.7 14.3 32 32 32h80V448c0 8.8-7.2 16-16 16H64zM64 0C28.7 0 0 28.7 0 64V448c0 35.3 28.7 64 64 64H320c35.3 0 64-28.7 64-64V154.5c0-17-6.7-33.3-18.7-45.3L274.7 18.7C262.7 6.7 246.5 0 229.5 0H64zm56 256c-13.3 0-24 10.7-24 24s10.7 24 24 24H264c13.3 0 24-10.7 24-24s-10.7-24-24-24H120zm0 96c-13.3 0-24 10.7-24 24s10.7 24 24 24H264c13.3 0 24-10.7 24-24s-10.7-24-24-24H120z"/>
                        </svg>
                        <span class="ml-2 text-sm font-semibold">Expenses</span>
                    </a>
                    <a href="{{ route('payments.form') }}" class="flex items-center text-gray-600 py-2 hover:text-blue-700">
                        <svg class="h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                            <path fill="currentColor" d="M512 80c8.8 0 16 7.2 16 16v32H48V96c0-8.8 7.2-16 16-16H512zm16 144V416c0 8.8-7.2 16-16 16H64c-8.8 0-16-7.2-16-16V224H528zM64 32C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H512c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H64zm56 304c-13.3 0-24 10.7-24 24s10.7 24 24 24h48c13.3 0 24-10.7 24-24s-10.7-24-24-24H120zm128 0c-13.3 0-24 10.7-24 24s10.7 24 24 24h48c13.3 0 24-10.7 24-24s-10.7-24-24-24H248z"/>
                        </svg>
                        <span class="ml-2 text-sm font-semibold">Payments Reports</span>
                    </a>
                    <a href="{{ route('form.expenses') }}" class="flex items-center text-gray-600 py-2 hover:text-blue-700">
                        <svg class="h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512">
                            <path fill="currentColor" d="M64 0C28.7 0 0 28.7 0 64V448c0 35.3 28.7 64 64 64H320c35.3 0 64-28.7 64-64V160H256c-17.7 0-32-14.3-32-32V0H64zM256 0V128H384L256 0zM112 256H272c8.8 0 16 7.2 16 16s-7.2 16-16 16H112c-8.8 0-16-7.2-16-16s7.2-16 16-16zm0 64H272c8.8 0 16 7.2 16 16s-7.2 16-16 16H112c-8.8 0-16-7.2-16-16s7.2-16 16-16z"/>
                        </svg>
                        <span class="ml-2 text-sm font-semibold">Expenses Reports</span>
                    </a>
                    <a href="{{ route('get.balanceform') }}" class="flex items-center text-gray-600 py-2 hover:text-blue-700">
                        <svg class="h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                            <path fill="currentColor" d="M0 96C0 60.7 28.7 32 64 32H512c35.3 0 64 28.7 64 64V416c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V96zm64 64V416H512V160H64zm96 64c0-17.7 14.3-32 32-32H384c17.7 0 32 14.3 32 32v64c0 17.7-14.3 32-32 32H192c-17.7 0-32-14.3-32-32V224zm32-16c-8.8 0-16 7.2-16 16v64c0 8.8 7.2 16 16 16H384c8.8 0 16-7.2 16-16V224c0-8.8-7.2-16-16-16H192zM144 352a32 32 0 1 1 0 64 32 32 0 1 1 0-64z"/>
                        </svg>
                        <span class="ml-2 text-sm font-semibold">Balance Reports</span>
                    </a>

                    <a href="{{ route('get.defaultersreportform') }}" class="flex items-center text-gray-600 py-2 hover:text-blue-700">
                        <svg class="h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                            <path fill="currentColor" d="M512 80c8.8 0 16 7.2 16 16v32H48V96c0-8.8 7.2-16 16-16H512zm16 144V416c0 8.8-7.2 16-16 16H64c-8.8 0-16-7.2-16-16V224H528zM64 32C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H512c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H64zm56 304c-13.3 0-24 10.7-24 24s10.7 24 24 24h48c13.3 0 24-10.7 24-24s-10.7-24-24-24H120zm128 0c-13.3 0-24 10.7-24 24s10.7 24 24 24h48c13.3 0 24-10.7 24-24s-10.7-24-24-24H248z"/>
                        </svg>
                        <span class="ml-2 text-sm font-semibold">Defaulters Reports</span>
                    </a>
                </div>
            </div>
        </div>

        <script>
        function toggleSubMenu1(submenuId, iconId) {
            event.preventDefault();
            const submenu = document.getElementById(submenuId);
            const icon = document.getElementById(iconId);
            
            // Toggle the submenu visibility
            submenu.classList.toggle('hidden');
            
            // Rotate the icon
            if (submenu.classList.contains('hidden')) {
                icon.classList.remove('rotate-180');
            } else {
                icon.classList.add('rotate-180');
            }
        }
        </script>

        <script>
            // Function to toggle the dropdown
            function toggleSubMenu2(menuId, iconId) {
                const submenu = document.getElementById(menuId);
                const icon = document.getElementById(iconId);
                const isHidden = submenu.classList.contains('hidden');
                
                // Toggle visibility
                submenu.classList.toggle('hidden');
                submenu.setAttribute('aria-hidden', isHidden ? 'false' : 'true');
        
                // Rotate icon
                icon.classList.toggle('rotate-180');
        
                // Update ARIA-expanded
                const trigger = document.querySelector(`[aria-controls="${menuId}"]`);
                trigger.setAttribute('aria-expanded', isHidden ? 'true' : 'false');
            }
        
            // Close dropdown when clicking outside
            document.addEventListener('click', (event) => {
                const submenu = document.getElementById('librarySubmenu2');
                const icon = document.getElementById('libraryIcon2');
                const trigger = document.querySelector('[aria-controls="librarySubmenu2"]');
        
                if (!submenu.contains(event.target) && !trigger.contains(event.target)) {
                    if (!submenu.classList.contains('hidden')) {
                        submenu.classList.add('hidden');
                        submenu.setAttribute('aria-hidden', 'true');
                        icon.classList.remove('rotate-180');
                        trigger.setAttribute('aria-expanded', 'false');
                    }
                }
            });
        </script>
        <a href="{{ route('student.enquires') }}" class="flex items-center text-gray-600 py-2 hover:text-blue-700">
            <svg class="h-4 w-4 fill-current" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="user-graduate" class="svg-inline--fa fa-user-graduate fa-w-14" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M319.4 320.6L224 416l-95.4-95.4C57.1 323.7 0 382.2 0 454.4v9.6c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48v-9.6c0-72.2-57.1-130.7-128.6-133.8zM13.6 79.8l6.4 1.5v58.4c-7 4.2-12 11.5-12 20.3 0 8.4 4.6 15.4 11.1 19.7L3.5 242c-1.7 6.9 2.1 14 7.6 14h41.8c5.5 0 9.3-7.1 7.6-14l-15.6-62.3C51.4 175.4 56 168.4 56 160c0-8.8-5-16.1-12-20.3V87.1l66 15.9c-8.6 17.2-14 36.4-14 57 0 70.7 57.3 128 128 128s128-57.3 128-128c0-20.6-5.3-39.8-14-57l96.3-23.2c18.2-4.4 18.2-27.1 0-31.5l-190.4-46c-13-3.1-26.7-3.1-39.7 0L13.6 48.2c-18.1 4.4-18.1 27.2 0 31.6z"></path></svg>
            <span class="ml-2 text-sm font-semibold">Enquiry</span>
        </a>
        @hasanyrole('Admin|rector')
        <div>
            <a href="#"
               class="flex items-center text-gray-600 py-2 hover:text-blue-700"
               onclick="toggleSubMenu2('librarySubmenu3','libraryIcon3')">
                <svg class="h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                    <path fill="currentColor" d="M249.6 471.3c10.8 3.8 22.4-4.1 22.4-15.5V67.9c0-4.2-1.6-8.4-5-11C247.4 45 202.4 32 144 32C93.5 32 46.3 45.5 18.1 56.1C6.8 60.5 0 71.7 0 83.8V454.1c0 11.9 12.8 20.2 24.1 16.5C55.6 460.1 105.5 448 144 448c33.9 0 79 14 105.6 23.3zm307.4-335L528 256h-48l-28.8-119.7c-1.8-7.2-7.2-12.3-14.6-12.3h-57c-5.2 0-9.8 2.6-12.6 6.7l-98.3 163.8c-3.2 5.3-3.4 12-.6 17.4L423 455.5c2.8 4.7 8.2 7.5 14.1 7.5h56.5c8.6 0 15.7-6.6 15.9-15.2l7-277.2c.1-6.6-4.8-12.2-11.4-12.7z"/>
                </svg>
                <span class="ml-2">Library & Books</span>
                <svg id="libraryIcon3" class="ml-auto h-4 w-4 transform transition-transform duration-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </a>
            <div id="librarySubmenu3" class="hidden pl-6 mt-2">
                <a href="{{ route('librarybooks') }}" class="flex items-center text-gray-600 py-2 hover:text-blue-700">
                    <svg class="h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                        <path fill="currentColor" d="M96 0C43 0 0 43 0 96V416c0 53 43 96 96 96H384h32c17.7 0 32-14.3 32-32s-14.3-32-32-32V384c17.7 0 32-14.3 32-32V32c0-17.7-14.3-32-32-32H384 96zm0 384H352v64H96c-17.7 0-32-14.3-32-32s14.3-32 32-32zm32-240c0-8.8 7.2-16 16-16H336c8.8 0 16 7.2 16 16s-7.2 16-16 16H144c-8.8 0-16-7.2-16-16zm16 48H336c8.8 0 16 7.2 16 16s-7.2 16-16 16H144c-8.8 0-16-7.2-16-16s7.2-16 16-16z"/>
                    </svg>
                    <span class="ml-2 text-sm font-semibold">Library & Books</span>
                </a>
                <a href="{{ route('past.questions') }}" class="flex items-center text-gray-600 py-2 hover:text-blue-700">
                    <svg class="h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                        <path fill="currentColor" d="M96 0C43 0 0 43 0 96V416c0 53 43 96 96 96H384h32c17.7 0 32-14.3 32-32s-14.3-32-32-32V384c17.7 0 32-14.3 32-32V32c0-17.7-14.3-32-32-32H384 96zm0 384H352v64H96c-17.7 0-32-14.3-32-32s14.3-32 32-32zm32-240c0-8.8 7.2-16 16-16H336c8.8 0 16 7.2 16 16s-7.2 16-16 16H144c-8.8 0-16-7.2-16-16zm16 48H336c8.8 0 16 7.2 16 16s-7.2 16-16 16H144c-8.8 0-16-7.2-16-16s7.2-16 16-16z"/>
                    </svg>
                    <span class="ml-2 text-sm font-semibold">Past Questions</span>
                </a>
            </div>
        </div>
        <div>
            <a href="#"
               class="flex items-center text-gray-600 py-2 hover:text-blue-700"
               onclick="toggleSubMenu3('librarySubmenu4','libraryIcon4')"
               aria-controls="librarySubmenu4"
               aria-expanded="false">
                <svg class="h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                    <path fill="currentColor" d="M128 64c0-35.3 28.7-64 64-64H352V128c0 17.7 14.3 32 32 32H512V448c0 35.3-28.7 64-64 64H192c-35.3 0-64-28.7-64-64V336H302.1l-39 39c-9.4 9.4-9.4 24.6 0 33.9s24.6 9.4 33.9 0l80-80c9.4-9.4 9.4-24.6 0-33.9l-80-80c-9.4-9.4-24.6-9.4-33.9 0s-9.4 24.6 0 33.9l39 39H128V64zm0 224v48H24c-13.3 0-24-10.7-24-24s10.7-24 24-24H128zM512 120.9V120c0-13.3-10.7-24-24-24H456c-13.3 0-24 10.7-24 24v.9c-18.5 7.4-32 25-32 45.1c0 20.1 13.5 37.7 32 45.1V216c0 13.3 10.7 24 24 24h32c13.3 0 24-10.7 24-24v-.9c18.5-7.4 32-25 32-45.1c0-20.1-13.5-37.7-32-45.1z"/>
                </svg>
                <span class="ml-2">Reports</span>
                <svg id="libraryIcon4" class="ml-auto h-4 w-4 transform transition-transform duration-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </a>
            <div id="librarySubmenu4" class="hidden pl-6 mt-2" aria-hidden="true">
                <a href="{{ route('reports.form') }}" class="flex items-center text-gray-600 py-2 hover:text-blue-700">
                    <svg class="h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512">
                        <path fill="currentColor" d="M320 32c-8.1 0-16.1 1.4-23.7 4.1L15.8 137.4C6.3 140.9 0 149.9 0 160s6.3 19.1 15.8 22.6l57.9 20.9C57.3 229.3 48 259.8 48 291.9v28.1c0 28.4-10.8 57.7-22.3 80.8c-6.5 13-13.9 25.8-22.5 37.6C0 442.7-.9 448.3 .9 453.4s6 8.9 11.2 10.2l64 16c4.2 1.1 8.7 .3 12.4-2s6.3-6.1 7.1-10.4c8.6-42.8 4.3-81.2-2.1-108.7C90.3 344.3 86 329.8 80 316.5V291.9c0-30.2 10.2-58.7 27.9-81.5c12.9-15.5 29.6-28 49.2-35.7l157-61.7c8.2-3.2 17.5 .8 20.7 9s-.8 17.5-9 20.7l-157 61.7c-12.4 4.9-23.3 12.4-32.2 21.6l159.6 57.6c7.6 2.7 15.6 4.1 23.7 4.1s16.1-1.4 23.7-4.1L624.2 182.6c9.5-3.4 15.8-12.5 15.8-22.6s-6.3-19.1-15.8-22.6L343.7 36.1C336.1 33.4 328.1 32 320 32zM128 408c0 35.3 86 72 192 72s192-36.7 192-72L496.7 262.6 354.5 314c-11.1 4-22.8 6-34.5 6s-23.5-2-34.5-6L143.3 262.6 128 408z"/>
                    </svg>
                    <span class="ml-2 text-sm font-semibold">Student Reports (Professional)</span>
                </a>
                <a href="{{ route('academic.reportsform') }}" class="flex items-center text-gray-600 py-2 hover:text-blue-700">
                    <svg class="h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512">
                        <path fill="currentColor" d="M320 32c-8.1 0-16.1 1.4-23.7 4.1L15.8 137.4C6.3 140.9 0 149.9 0 160s6.3 19.1 15.8 22.6l57.9 20.9C57.3 229.3 48 259.8 48 291.9v28.1c0 28.4-10.8 57.7-22.3 80.8c-6.5 13-13.9 25.8-22.5 37.6C0 442.7-.9 448.3 .9 453.4s6 8.9 11.2 10.2l64 16c4.2 1.1 8.7 .3 12.4-2s6.3-6.1 7.1-10.4c8.6-42.8 4.3-81.2-2.1-108.7C90.3 344.3 86 329.8 80 316.5V291.9c0-30.2 10.2-58.7 27.9-81.5c12.9-15.5 29.6-28 49.2-35.7l157-61.7c8.2-3.2 17.5 .8 20.7 9s-.8 17.5-9 20.7l-157 61.7c-12.4 4.9-23.3 12.4-32.2 21.6l159.6 57.6c7.6 2.7 15.6 4.1 23.7 4.1s16.1-1.4 23.7-4.1L624.2 182.6c9.5-3.4 15.8-12.5 15.8-22.6s-6.3-19.1-15.8-22.6L343.7 36.1C336.1 33.4 328.1 32 320 32zM128 408c0 35.3 86 72 192 72s192-36.7 192-72L496.7 262.6 354.5 314c-11.1 4-22.8 6-34.5 6s-23.5-2-34.5-6L143.3 262.6 128 408z"/>
                    </svg>
                    <span class="ml-2 text-sm font-semibold">Student Reports (Academic)</span>
                </a>
                <a href="{{ route('get.deferlistform') }}" class="flex items-center text-gray-600 py-2 hover:text-blue-700">
                    <svg class="h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                        <path fill="currentColor" d="M224 256c70.7 0 128-57.3 128-128S294.7 0 224 0 96 57.3 96 128s57.3 128 128 128zm89.6 32h-16.7c-22.2 10.2-46.9 16-72.9 16s-50.6-5.8-72.9-16h-16.7C60.2 288 0 348.2 0 422.4V464c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48v-41.6c0-74.2-60.2-134.4-134.4-134.4z"/>
                    </svg>
                    <span class="ml-2 text-sm font-semibold">Defer List</span>
                </a>
                <a href="{{ route('teacherreport.form') }}" class="flex items-center text-gray-600 py-2 hover:text-blue-700">
                    <svg class="h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                        <path fill="currentColor" d="M224 256c70.7 0 128-57.3 128-128S294.7 0 224 0 96 57.3 96 128s57.3 128 128 128zm89.6 32h-16.7c-22.2 10.2-46.9 16-72.9 16s-50.6-5.8-72.9-16h-16.7C60.2 288 0 348.2 0 422.4V464c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48v-41.6c0-74.2-60.2-134.4-134.4-134.4z"/>
                    </svg>
                    <span class="ml-2 text-sm font-semibold">Teacher Reports</span>
                </a>
                <a href="{{ route('payments.form') }}" class="flex items-center text-gray-600 py-2 hover:text-blue-700">
                    <svg class="h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                        <path fill="currentColor" d="M512 80c8.8 0 16 7.2 16 16v32H48V96c0-8.8 7.2-16 16-16H512zm16 144V416c0 8.8-7.2 16-16 16H64c-8.8 0-16-7.2-16-16V224H528zM64 32C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H512c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H64zm56 304c-13.3 0-24 10.7-24 24s10.7 24 24 24h48c13.3 0 24-10.7 24-24s-10.7-24-24-24H120zm128 0c-13.3 0-24 10.7-24 24s10.7 24 24 24h48c13.3 0 24-10.7 24-24s-10.7-24-24-24H248z"/>
                    </svg>
                    <span class="ml-2 text-sm font-semibold">Payments Reports</span>
                </a>
                <a href="{{ route('form.expenses') }}" class="flex items-center text-gray-600 py-2 hover:text-blue-700">
                    <svg class="h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512">
                        <path fill="currentColor" d="M64 0C28.7 0 0 28.7 0 64V448c0 35.3 28.7 64 64 64H320c35.3 0 64-28.7 64-64V160H256c-17.7 0-32-14.3-32-32V0H64zM256 0V128H384L256 0zM112 256H272c8.8 0 16 7.2 16 16s-7.2 16-16 16H112c-8.8 0-16-7.2-16-16s7.2-16 16-16zm0 64H272c8.8 0 16 7.2 16 16s-7.2 16-16 16H112c-8.8 0-16-7.2-16-16s7.2-16 16-16z"/>
                    </svg>
                    <span class="ml-2 text-sm font-semibold">Expenses Reports</span>
                </a>
                <a href="{{ route('get.balanceform') }}" class="flex items-center text-gray-600 py-2 hover:text-blue-700">
                    <svg class="h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                        <path fill="currentColor" d="M0 96C0 60.7 28.7 32 64 32H512c35.3 0 64 28.7 64 64V416c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V96zm64 64V416H512V160H64zm96 64c0-17.7 14.3-32 32-32H384c17.7 0 32 14.3 32 32v64c0 17.7-14.3 32-32 32H192c-17.7 0-32-14.3-32-32V224zm32-16c-8.8 0-16 7.2-16 16v64c0 8.8 7.2 16 16 16H384c8.8 0 16-7.2 16-16V224c0-8.8-7.2-16-16-16H192zM144 352a32 32 0 1 1 0 64 32 32 0 1 1 0-64z"/>
                    </svg>
                    <span class="ml-2 text-sm font-semibold">Balance Reports</span>
                </a>
            </div>
        </div>
        <div>
            <a href="#"
               class="flex items-center text-gray-600 py-2 hover:text-blue-700"
               onclick="toggle104('librarySubmenu110', 'libraryIcon110')">
                <svg class="h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                    <path fill="currentColor" d="M495.9 166.6c3.2 8.7 .5 18.4-6.4 24.6l-43.3 39.4c1.1 8.3 1.7 16.8 1.7 25.4s-.6 17.1-1.7 25.4l43.3 39.4c6.9 6.2 9.6 15.9 6.4 24.6c-4.4 11.9-9.7 23.3-15.8 34.3l-4.7 8.1c-6.6 11-14 21.4-22.1 31.2c-5.9 7.2-15.7 9.6-24.5 6.8l-55.7-17.7c-13.4 10.3-28.2 18.9-44 25.4l-12.5 57.1c-2 9.1-9 16.3-18.2 17.8c-13.8 2.3-28 3.5-42.5 3.5s-28.7-1.2-42.5-3.5c-9.2-1.5-16.2-8.7-18.2-17.8l-12.5-57.1c-15.8-6.5-30.6-15.1-44-25.4l-55.7 17.7c-8.8 2.8-18.6 .4-24.5-6.8c-8.1-9.8-15.5-20.2-22.1-31.2l-4.7-8.1c-6.1-11-11.4-22.4-15.8-34.3c-3.2-8.7-.5-18.4 6.4-24.6l43.3-39.4C64.6 273.1 64 264.6 64 256s.6-17.1 1.7-25.4L22.4 191.2c-6.9-6.2-9.6-15.9-6.4-24.6c4.4-11.9 9.7-23.3 15.8-34.3l4.7-8.1c6.6-11 14-21.4 22.1-31.2c5.9-7.2 15.7-9.6 24.5-6.8l55.7 17.7c13.4-10.3 28.2-18.9 44-25.4l12.5-57.1c2-9.1 9-16.3 18.2-17.8C227.3 1.2 241.5 0 256 0s28.7 1.2 42.5 3.5c9.2 1.5 16.2 8.7 18.2 17.8l12.5 57.1c15.8 6.5 30.6 15.1 44 25.4l55.7-17.7c8.8-2.8 18.6-.4 24.5 6.8c8.1 9.8 15.5 20.2 22.1 31.2l4.7 8.1c6.1 11 11.4 22.4 15.8 34.3zM256 336a80 80 0 1 0 0-160 80 80 0 1 0 0 160z"/>
                </svg>
                <span class="ml-2">Settings</span>
                <svg id="libraryIcon110" class="ml-auto h-4 w-4 transform transition-transform duration-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </a>
            <div id="librarySubmenu110" class="hidden pl-6 mt-2">
                <div>
                    <a href="{{ route('settings.set') }}" class="flex items-center text-gray-600 py-2 hover:text-blue-700">
                        <svg class="h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                            <path fill="currentColor" d="M500 224H376c-13.3 0-24-10.7-24-24V76c0-6.6 5.4-12 12-12h40c6.6 0 12 5.4 12 12v84h84c6.6 0 12 5.4 12 12v40c0 6.6-5.4 12-12 12zm-340-24V76c0-6.6-5.4-12-12-12h-40c-6.6 0-12 5.4-12 12v84H12c-6.6 0-12 5.4-12 12v40c0 6.6 5.4 12 12 12h124c13.3 0 24-10.7 24-24zm0 236V312c0-13.3-10.7-24-24-24H12c-6.6 0-12 5.4-12 12v40c0 6.6 5.4 12 12 12h84v84c0 6.6 5.4 12 12 12h40c6.6 0 12-5.4 12-12zm224 0v-84h84c6.6 0 12-5.4 12-12v-40c0-6.6-5.4-12-12-12H376c-13.3 0-24 10.7-24 24v124c0 6.6 5.4 12 12 12h40c6.6 0 12-5.4 12-12z"/>
                        </svg>
                        <span class="ml-2 text-sm font-semibold">Settings</span>
                    </a>
                    <a href="{{ route('get.deletedstudents') }}" class="flex items-center text-gray-600 py-2 hover:text-blue-700">
                        <svg class="h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512">
                            <path fill="currentColor" d="M224 256c70.7 0 128-57.3 128-128S294.7 0 224 0 96 57.3 96 128s57.3 128 128 128zm89.6 32h-16.7c-22.2 10.2-46.9 16-72.9 16s-50.6-5.8-72.9-16h-16.7C60.2 288 0 348.2 0 422.4V464c0 26.5 21.5 48 48 48h274.9c-2.4-6.8-3.4-14-2.6-21.3l6.8-60.9 1.2-11.1 7.9-7.9 77.3-77.3c-24.5-27.7-60-45.5-99.9-45.5zm45.3 145.3l-6.8 61c-1.1 10.2 7.5 18.8 17.6 17.6l60.9-6.8 137.9-137.9-71.7-71.7-137.9 137.8zM633 268.9L595.1 231c-9.3-9.3-24.5-9.3-33.8 0l-37.8 37.8-4.1 4.1 71.8 71.7 41.8-41.8c9.3-9.4 9.3-24.5 0-33.9z"/>
                        </svg>
                        <span class="ml-2 text-sm font-semibold">View Deleted Students</span>
                    </a>
                    <a href="{{ route('assignrole.index') }}" class="flex items-center text-gray-600 py-2 hover:text-blue-700">
                        <svg class="h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512">
                            <path fill="currentColor" d="M224 256c70.7 0 128-57.3 128-128S294.7 0 224 0 96 57.3 96 128s57.3 128 128 128zm89.6 32h-16.7c-22.2 10.2-46.9 16-72.9 16s-50.6-5.8-72.9-16h-16.7C60.2 288 0 348.2 0 422.4V464c0 26.5 21.5 48 48 48h274.9c-2.4-6.8-3.4-14-2.6-21.3l6.8-60.9 1.2-11.1 7.9-7.9 77.3-77.3c-24.5-27.7-60-45.5-99.9-45.5zm45.3 145.3l-6.8 61c-1.1 10.2 7.5 18.8 17.6 17.6l60.9-6.8 137.9-137.9-71.7-71.7-137.9 137.8zM633 268.9L595.1 231c-9.3-9.3-24.5-9.3-33.8 0l-37.8 37.8-4.1 4.1 71.8 71.7 41.8-41.8c9.3-9.4 9.3-24.5 0-33.9z"/>
                        </svg>
                        <span class="ml-2 text-sm font-semibold">Assign Role</span>
                    </a>
                    <a href="{{ route('roles-permissions') }}" class="flex items-center text-gray-600 py-2 hover:text-blue-700">
                        <svg class="h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512">
                            <path fill="currentColor" d="M512 64V352H128V64H512zM128 32C92.7 32 64 60.7 64 96V352c0 35.3 28.7 64 64 64H512c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H128zM480 96H160V320H480V96zM24 120c-13.3 0-24 10.7-24 24s10.7 24 24 24H64v64H24c-13.3 0-24 10.7-24 24s10.7 24 24 24H64v64H24c-13.3 0-24 10.7-24 24s10.7 24 24 24H64v32c0 35.3 28.7 64 64 64h32V424H120c-13.3 0-24-10.7-24-24s10.7-24 24-24h40V312H120c-13.3 0-24-10.7-24-24s10.7-24 24-24h40V200H120c-13.3 0-24-10.7-24-24s10.7-24 24-24H64V96H24z"/>
                        </svg>
                        <span class="ml-2 text-sm font-semibold">Roles &amp; Permissions</span>
                    </a>
                    <a href="{{ route('student.migration') }}" class="flex items-center text-gray-600 py-2 hover:text-blue-700">
                        <svg class="h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512">
                            <path fill="currentColor" d="M0 88C0 39.4 39.4 0 88 0h80c13.3 0 24 10.7 24 24v8h40c13.3 0 24 10.7 24 24s-10.7 24-24 24h-8v48h8c13.3 0 24 10.7 24 24s-10.7 24-24 24h-8v48h8c13.3 0 24 10.7 24 24s-10.7 24-24 24h-8v48h8c13.3 0 24 10.7 24 24s-10.7 24-24 24h-8v8c0 13.3-10.7 24-24 24s-24-10.7-24-24v-8h-8c-13.3 0-24-10.7-24-24s10.7-24 24-24h8V256h-8c-13.3 0-24-10.7-24-24s10.7-24 24-24h8V160h-8c-13.3 0-24-10.7-24-24s10.7-24 24-24h8V64h-8c-13.3 0-24-10.7-24-24s10.7-24 24-24h8V24c0-13.3-10.7-24-24-24H88C39.4 0 0 39.4 0 88zM344 0h80c13.3 0 24 10.7 24 24v464c0 13.3-10.7 24-24 24s-24-10.7-24-24V48H344c-13.3 0-24-10.7-24-24s10.7-24 24-24zM192 488c0 13.3 10.7 24 24 24h80c13.3 0 24-10.7 24-24V24c0-13.3-10.7-24-24-24h-80c-13.3 0-24 10.7-24 24V488z"/>
                        </svg>
                        <span class="ml-2 text-sm font-semibold">Migration</span>
                    </a>
                    <a href="{{ route('attendance.index') }}" class="flex items-center text-gray-600 py-2 hover:text-blue-700">
                        <svg class="h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                            <path fill="currentColor" d="M160 32V64H288V32c0-17.7-14.3-32-32-32H192c-17.7 0-32 14.3-32 32zM128 64V32c0-35.3 28.7-64 64-64H256c35.3 0 64 28.7 64 64V64h48c26.5 0 48 21.5 48 48v48H32V112c0-26.5 21.5-48 48-48h48zM32 192H416V464c0 26.5-21.5 48-48 48H80c-26.5 0-48-21.5-48-48V192zm144 80c0 8.8-7.2 16-16 16s-16-7.2-16-16s7.2-16 16-16s16 7.2 16 16zm128 16c-8.8 0-16-7.2-16-16s7.2-16 16-16s16 7.2 16 16s-7.2 16-16 16zM144 400c0 8.8-7.2 16-16 16s-16-7.2-16-16s7.2-16 16-16s16 7.2 16 16zm128 16c-8.8 0-16-7.2-16-16s7.2-16 16-16s16 7.2 16 16s-7.2 16-16 16z"/>
                        </svg>
                        <span class="ml-2 text-sm font-semibold">Attendance</span>
                    </a>
                </div>
            </div>
        </div>
    
        <script>
            function toggle104(submenuId, iconId) {
                event.preventDefault(); // Prevent default anchor behavior
                
                const submenu = document.getElementById(submenuId);
                const icon = document.getElementById(iconId);
                
                // Toggle submenu visibility
                submenu.classList.toggle('hidden');
                
                // Rotate the chevron icon
                icon.classList.toggle('rotate-180');
            }
        </script>

        @endhasanyrole
        
        
        
        
        <!-- Fees -->
        
        
        
        <script>
            // Function to toggle the dropdown
            function toggleSubMenu3(menuId, iconId) {
                const submenu = document.getElementById(menuId);
                const icon = document.getElementById(iconId);
                const isHidden = submenu.classList.contains('hidden');
                
                // Toggle visibility
                submenu.classList.toggle('hidden');
                submenu.setAttribute('aria-hidden', isHidden ? 'false' : 'true');
            
                // Rotate icon
                icon.classList.toggle('rotate-180');
            
                // Update ARIA-expanded
                const trigger = document.querySelector(`[aria-controls="${menuId}"]`);
                trigger.setAttribute('aria-expanded', isHidden ? 'true' : 'false');
            }
            
            // Close dropdown when clicking outside
            document.addEventListener('click', (event) => {
                const submenu = document.getElementById('librarySubmenu4');
                const icon = document.getElementById('libraryIcon4');
                const trigger = document.querySelector('[aria-controls="librarySubmenu4"]');
            
                if (!submenu.contains(event.target) && !trigger.contains(event.target)) {
                    if (!submenu.classList.contains('hidden')) {
                        submenu.classList.add('hidden');
                        submenu.setAttribute('aria-hidden', 'true');
                        icon.classList.remove('rotate-180');
                        trigger.setAttribute('aria-expanded', 'false');
                    }
                }
            });
        </script>
        <script>
            // Function to toggle the dropdown
            function toggleSubMenu5(menuId, iconId) {
                const submenu = document.getElementById(menuId);
                const icon = document.getElementById(iconId);
                const isHidden = submenu.classList.contains('hidden');
                
                // Toggle visibility
                submenu.classList.toggle('hidden');
                submenu.setAttribute('aria-hidden', isHidden ? 'false' : 'true');
            
                // Rotate icon
                icon.classList.toggle('rotate-180');
            
                // Update ARIA-expanded
                const trigger = document.querySelector(`[aria-controls="${menuId}"]`);
                trigger.setAttribute('aria-expanded', isHidden ? 'true' : 'false');
            }
            
            // Close dropdown when clicking outside
            document.addEventListener('click', (event) => {
                const submenu = document.getElementById('librarySubmenu5');
                const icon = document.getElementById('libraryIcon5');
                const trigger = document.querySelector('[aria-controls="librarySubmenu5"]');
            
                if (!submenu.contains(event.target) && !trigger.contains(event.target)) {
                    if (!submenu.classList.contains('hidden')) {
                        submenu.classList.add('hidden');
                        submenu.setAttribute('aria-hidden', 'true');
                        icon.classList.remove('rotate-180');
                        trigger.setAttribute('aria-expanded', 'false');
                    }
                }
            });
        </script>

        
        
        
        <script>
            function toggleMenu(submenuId) {
                const submenu = document.getElementById(submenuId);
                submenu.classList.toggle('hidden');
            }
        </script>
        <script>
            function toggleSubMenu(submenuId) {
                const submenu = document.getElementById(submenuId);
                const icon = document.getElementById('feesIcon');
        
                // Toggle visibility of submenu
                submenu.classList.toggle('hidden');
        
                // Rotate the arrow icon
                if (submenu.classList.contains('hidden')) {
                    icon.classList.remove('rotate-180');
                } else {
                    icon.classList.add('rotate-180');
                }
            }
        </script>
        <script>
          function toggleSubMenu(submenuId, iconId) {
            const submenu = document.getElementById(submenuId);
            const icon = document.getElementById(iconId);

            if (submenu.classList.contains('hidden')) {
                submenu.classList.remove('hidden');
                icon.classList.add('rotate-180'); // Rotate the arrow downwards
            } else {
                submenu.classList.add('hidden');
                icon.classList.remove('rotate-180'); // Reset arrow to default
            }
         }
        </script>
        @endrole
        @hasrole('Librarian')
        <div>
        <a href="#"
            class="flex items-center text-gray-600 py-2 hover:text-blue-700"
            onclick="toggleSubMenu889('librarySubmenu34','libraryIcon34')">
            <svg class="h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                <path fill="currentColor" d="M249.6 471.3c10.8 3.8 22.4-4.1 22.4-15.5V67.9c0-4.2-1.6-8.4-5-11C247.4 45 202.4 32 144 32C93.5 32 46.3 45.5 18.1 56.1C6.8 60.5 0 71.7 0 83.8V454.1c0 11.9 12.8 20.2 24.1 16.5C55.6 460.1 105.5 448 144 448c33.9 0 79 14 105.6 23.3zm307.4-335L528 256h-48l-28.8-119.7c-1.8-7.2-7.2-12.3-14.6-12.3h-57c-5.2 0-9.8 2.6-12.6 6.7l-98.3 163.8c-3.2 5.3-3.4 12-.6 17.4L423 455.5c2.8 4.7 8.2 7.5 14.1 7.5h56.5c8.6 0 15.7-6.6 15.9-15.2l7-277.2c.1-6.6-4.8-12.2-11.4-12.7z"/>
            </svg>
            <span class="ml-2">Library & Books</span>
            <svg id="libraryIcon34" class="ml-auto h-4 w-4 transform transition-transform duration-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg>
        </a>
        <div id="librarySubmenu34" class="hidden pl-6 mt-2">
            <a href="{{ route('librarybooks') }}" class="flex items-center text-gray-600 py-2 hover:text-blue-700">
                <svg class="h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                    <path fill="currentColor" d="M96 0C43 0 0 43 0 96V416c0 53 43 96 96 96H384h32c17.7 0 32-14.3 32-32s-14.3-32-32-32V384c17.7 0 32-14.3 32-32V32c0-17.7-14.3-32-32-32H384 96zm0 384H352v64H96c-17.7 0-32-14.3-32-32s14.3-32 32-32zm32-240c0-8.8 7.2-16 16-16H336c8.8 0 16 7.2 16 16s-7.2 16-16 16H144c-8.8 0-16-7.2-16-16zm16 48H336c8.8 0 16 7.2 16 16s-7.2 16-16 16H144c-8.8 0-16-7.2-16-16s7.2-16 16-16z"/>
                </svg>
                <span class="ml-2 text-sm font-semibold">Library & Books</span>
            </a>
            <a href="{{ route('past.questions') }}" class="flex items-center text-gray-600 py-2 hover:text-blue-700">
                <svg class="h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                    <path fill="currentColor" d="M96 0C43 0 0 43 0 96V416c0 53 43 96 96 96H384h32c17.7 0 32-14.3 32-32s-14.3-32-32-32V384c17.7 0 32-14.3 32-32V32c0-17.7-14.3-32-32-32H384 96zm0 384H352v64H96c-17.7 0-32-14.3-32-32s14.3-32 32-32zm32-240c0-8.8 7.2-16 16-16H336c8.8 0 16 7.2 16 16s-7.2 16-16 16H144c-8.8 0-16-7.2-16-16zm16 48H336c8.8 0 16 7.2 16 16s-7.2 16-16 16H144c-8.8 0-16-7.2-16-16s7.2-16 16-16z"/>
                </svg>
                <span class="ml-2 text-sm font-semibold">Past Questions</span>
            </a>
        </div>
        </div>
        @endhasrole

        <script>
            // Function to toggle the dropdown
            function toggleSubMenu889(menuId, iconId) {
                const submenu = document.getElementById(menuId);
                const icon = document.getElementById(iconId);
                const isHidden = submenu.classList.contains('hidden');
                
                // Toggle visibility
                submenu.classList.toggle('hidden');
                submenu.setAttribute('aria-hidden', isHidden ? 'false' : 'true');
        
                // Rotate icon
                icon.classList.toggle('rotate-180');
        
                // Update ARIA-expanded
                const trigger = document.querySelector(`[aria-controls="${menuId}"]`);
                trigger.setAttribute('aria-expanded', isHidden ? 'true' : 'false');
            }
        
            // Close dropdown when clicking outside
            document.addEventListener('click', (event) => {
                const submenu = document.getElementById('librarySubmenu2');
                const icon = document.getElementById('libraryIcon2');
                const trigger = document.querySelector('[aria-controls="librarySubmenu2"]');
        
                if (!submenu.contains(event.target) && !trigger.contains(event.target)) {
                    if (!submenu.classList.contains('hidden')) {
                        submenu.classList.add('hidden');
                        submenu.setAttribute('aria-hidden', 'true');
                        icon.classList.remove('rotate-180');
                        trigger.setAttribute('aria-expanded', 'false');
                    }
                }
            });
        </script>






        @hasrole('AsstAccount')
            <a href="{{ route('student.index') }}" class="flex items-center text-gray-600 py-2 hover:text-blue-700">
                <svg class="h-4 w-4 fill-current" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="user-graduate" class="svg-inline--fa fa-user-graduate fa-w-14" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M319.4 320.6L224 416l-95.4-95.4C57.1 323.7 0 382.2 0 454.4v9.6c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48v-9.6c0-72.2-57.1-130.7-128.6-133.8zM13.6 79.8l6.4 1.5v58.4c-7 4.2-12 11.5-12 20.3 0 8.4 4.6 15.4 11.1 19.7L3.5 242c-1.7 6.9 2.1 14 7.6 14h41.8c5.5 0 9.3-7.1 7.6-14l-15.6-62.3C51.4 175.4 56 168.4 56 160c0-8.8-5-16.1-12-20.3V87.1l66 15.9c-8.6 17.2-14 36.4-14 57 0 70.7 57.3 128 128 128s128-57.3 128-128c0-20.6-5.3-39.8-14-57l96.3-23.2c18.2-4.4 18.2-27.1 0-31.5l-190.4-46c-13-3.1-26.7-3.1-39.7 0L13.6 48.2c-18.1 4.4-18.1 27.2 0 31.6z"></path></svg>
                <span class="ml-2 text-sm font-semibold">Students</span>
            </a>
            <a href="{{ route('get.transactions') }}" class="flex items-center text-gray-600 py-2 hover:text-blue-700">
                <svg class="h-4 w-4 fill-current" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="user-cog" class="svg-inline--fa fa-user-cog fa-w-20" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><path fill="currentColor" d="M610.5 373.3c2.6-14.1 2.6-28.5 0-42.6l25.8-14.9c3-1.7 4.3-5.2 3.3-8.5-6.7-21.6-18.2-41.2-33.2-57.4-2.3-2.5-6-3.1-9-1.4l-25.8 14.9c-10.9-9.3-23.4-16.5-36.9-21.3v-29.8c0-3.4-2.4-6.4-5.7-7.1-22.3-5-45-4.8-66.2 0-3.3.7-5.7 3.7-5.7 7.1v29.8c-13.5 4.8-26 12-36.9 21.3l-25.8-14.9c-2.9-1.7-6.7-1.1-9 1.4-15 16.2-26.5 35.8-33.2 57.4-1 3.3.4 6.8 3.3 8.5l25.8 14.9c-2.6 14.1-2.6 28.5 0 42.6l-25.8 14.9c-3 1.7-4.3 5.2-3.3 8.5 6.7 21.6 18.2 41.1 33.2 57.4 2.3 2.5 6 3.1 9 1.4l25.8-14.9c10.9 9.3 23.4 16.5 36.9 21.3v29.8c0 3.4 2.4 6.4 5.7 7.1 22.3 5 45 4.8 66.2 0 3.3-.7 5.7-3.7 5.7-7.1v-29.8c13.5-4.8 26-12 36.9-21.3l25.8 14.9c2.9 1.7 6.7 1.1 9-1.4 15-16.2 26.5-35.8 33.2-57.4 1-3.3-.4-6.8-3.3-8.5l-25.8-14.9zM496 400.5c-26.8 0-48.5-21.8-48.5-48.5s21.8-48.5 48.5-48.5 48.5 21.8 48.5 48.5-21.7 48.5-48.5 48.5zM224 256c70.7 0 128-57.3 128-128S294.7 0 224 0 96 57.3 96 128s57.3 128 128 128zm201.2 226.5c-2.3-1.2-4.6-2.6-6.8-3.9l-7.9 4.6c-6 3.4-12.8 5.3-19.6 5.3-10.9 0-21.4-4.6-28.9-12.6-18.3-19.8-32.3-43.9-40.2-69.6-5.5-17.7 1.9-36.4 17.9-45.7l7.9-4.6c-.1-2.6-.1-5.2 0-7.8l-7.9-4.6c-16-9.2-23.4-28-17.9-45.7.9-2.9 2.2-5.8 3.2-8.7-3.8-.3-7.5-1.2-11.4-1.2h-16.7c-22.2 10.2-46.9 16-72.9 16s-50.6-5.8-72.9-16h-16.7C60.2 288 0 348.2 0 422.4V464c0 26.5 21.5 48 48 48h352c10.1 0 19.5-3.2 27.2-8.5-1.2-3.8-2-7.7-2-11.8v-9.2z"></path></svg>
                <span class="ml-2 text-sm font-semibold">Transactions</span>
            </a>
            <div>
                <a href="#"
                    class="flex items-center text-gray-600 py-2 hover:text-blue-700"
                    onclick="toggleSubMenu('feesSubmenu')">
                    <svg class="h-4 w-4 fill-current" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512">
                        <path fill="currentColor" d="M610.5 373.3c2.6-14.1 2.6-28.5 0-42.6..."></path>
                    </svg>
                    <span class="ml-2">Fees</span>
                    <svg class="ml-auto h-4 w-4 transform transition-transform duration-300" id="feesIcon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </a>
                <div id="feesSubmenu" class="hidden pl-6 mt-2">
                    {{-- <a href="{{route('fees.show')}}" class="block px-2 py-1 text-gray-600 hover:bg-gray-200 rounded">Set School Fees</a> --}}
                    {{-- <a href="{{route('fees.collect')}}" class="block px-2 py-1 text-gray-600 hover:bg-gray-200 rounded">Collect School Fees</a> --}}
                    <a href="{{route('fees.defaulters')}}" class="block px-2 py-1 text-gray-600 hover:bg-gray-200 rounded">Defaulters</a>
                </div>
            </div>
            <script>
                function toggleMenu(submenuId) {
                    const submenu = document.getElementById(submenuId);
                    submenu.classList.toggle('hidden');
                }
            </script>
            <script>
                function toggleSubMenu(submenuId) {
                    const submenu = document.getElementById(submenuId);
                    const icon = document.getElementById('feesIcon');
            
                    // Toggle visibility of submenu
                    submenu.classList.toggle('hidden');
            
                    // Rotate the arrow icon
                    if (submenu.classList.contains('hidden')) {
                        icon.classList.remove('rotate-180');
                    } else {
                        icon.classList.add('rotate-180');
                    }
                }
            </script>
            <a href="{{ route('expenses.table') }}" class="flex items-center text-gray-600 py-2 hover:text-blue-700">
                <svg class="h-4 w-4 fill-current" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="user-edit" class="svg-inline--fa fa-user-edit fa-w-20" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><path fill="currentColor" d="M224 256c70.7 0 128-57.3 128-128S294.7 0 224 0 96 57.3 96 128s57.3 128 128 128zm89.6 32h-16.7c-22.2 10.2-46.9 16-72.9 16s-50.6-5.8-72.9-16h-16.7C60.2 288 0 348.2 0 422.4V464c0 26.5 21.5 48 48 48h274.9c-2.4-6.8-3.4-14-2.6-21.3l6.8-60.9 1.2-11.1 7.9-7.9 77.3-77.3c-24.5-27.7-60-45.5-99.9-45.5zm45.3 145.3l-6.8 61c-1.1 10.2 7.5 18.8 17.6 17.6l60.9-6.8 137.9-137.9-71.7-71.7-137.9 137.8zM633 268.9L595.1 231c-9.3-9.3-24.5-9.3-33.8 0l-37.8 37.8-4.1 4.1 71.8 71.7 41.8-41.8c9.3-9.4 9.3-24.5 0-33.9z"></path></svg>
                <span class="ml-2 text-sm font-semibold">Expenses</span>
            </a>
            <div>
                <a href="#"
                   class="flex items-center text-gray-600 py-2 hover:text-blue-700"
                   onclick="toggleSubMenu3('librarySubmenu4','libraryIcon4')"
                   aria-controls="librarySubmenu4"
                   aria-expanded="false">
                    <svg id="libraryIcon4" class="h-4 w-4 fill-current" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512">
                        <path fill="currentColor" d="M610.5 373.3c2.6-14.1 2.6-28.5 0-42.6..."></path>
                    </svg>
                    <span class="ml-2">Reports</span>
                    <svg id="libraryIcon4" class="ml-auto h-4 w-4 transform transition-transform duration-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </a>
                <div id="librarySubmenu4" class="hidden pl-6 mt-2" aria-hidden="true">
                    <a href="{{ route('reports.form') }}" class="flex items-center text-gray-600 py-2 hover:text-blue-700">
                        <span class="ml-2 text-sm font-semibold">Student Reports(Professional)</span>
                    </a>
                    <a href="{{ route('academic.reportsform') }}" class="flex items-center text-gray-600 py-2 hover:text-blue-700">
                        <span class="ml-2 text-sm font-semibold">Student Reports(Academic)</span>
                    </a>
                    {{-- <a href="{{ route('teacherreport.form') }}" class="flex items-center text-gray-600 py-2 hover:text-blue-700">
                        <span class="ml-2 text-sm font-semibold">Teacher Reports</span>
                    </a> --}}
                    <a href="{{ route('payments.form') }}" class="flex items-center text-gray-600 py-2 hover:text-blue-700">
                        <span class="ml-2 text-sm font-semibold">Payments Reports</span>
                    </a>
                    <a href="{{ route('form.expenses') }}" class="flex items-center text-gray-600 py-2 hover:text-blue-700">
                        <span class="ml-2 text-sm font-semibold">Expenses Reports</span>
                    </a>
                    <a href="{{ route('get.balanceform') }}" class="flex items-center text-gray-600 py-2 hover:text-blue-700">
                        <span class="ml-2 text-sm font-semibold">Balance Reports</span>
                    </a>
                    <a href="{{ route('get.defaultersreportform') }}" class="flex items-center text-gray-600 py-2 hover:text-blue-700">
                        <svg class="h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                            <path fill="currentColor" d="M512 80c8.8 0 16 7.2 16 16v32H48V96c0-8.8 7.2-16 16-16H512zm16 144V416c0 8.8-7.2 16-16 16H64c-8.8 0-16-7.2-16-16V224H528zM64 32C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H512c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H64zm56 304c-13.3 0-24 10.7-24 24s10.7 24 24 24h48c13.3 0 24-10.7 24-24s-10.7-24-24-24H120zm128 0c-13.3 0-24 10.7-24 24s10.7 24 24 24h48c13.3 0 24-10.7 24-24s-10.7-24-24-24H248z"/>
                        </svg>
                        <span class="ml-2 text-sm font-semibold">Defaulters Reports</span>
                    </a>
                </div>
                <script>
            // Function to toggle the dropdown
            function toggleSubMenu3(menuId, iconId) {
                const submenu = document.getElementById(menuId);
                const icon = document.getElementById(iconId);
                const isHidden = submenu.classList.contains('hidden');
                
                // Toggle visibility
                submenu.classList.toggle('hidden');
                submenu.setAttribute('aria-hidden', isHidden ? 'false' : 'true');
            
                // Rotate icon
                icon.classList.toggle('rotate-180');
            
                // Update ARIA-expanded
                const trigger = document.querySelector(`[aria-controls="${menuId}"]`);
                trigger.setAttribute('aria-expanded', isHidden ? 'true' : 'false');
            }
            
            // Close dropdown when clicking outside
            document.addEventListener('click', (event) => {
                const submenu = document.getElementById('librarySubmenu4');
                const icon = document.getElementById('libraryIcon4');
                const trigger = document.querySelector('[aria-controls="librarySubmenu4"]');
            
                if (!submenu.contains(event.target) && !trigger.contains(event.target)) {
                    if (!submenu.classList.contains('hidden')) {
                        submenu.classList.add('hidden');
                        submenu.setAttribute('aria-hidden', 'true');
                        icon.classList.remove('rotate-180');
                        trigger.setAttribute('aria-expanded', 'false');
                    }
                }
            });
        </script>
        <a href="{{ route('settings.set') }}" class="flex items-center text-gray-600 py-2 hover:text-blue-700">
            <svg class="h-4 w-4 fill-current" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="user-cog" class="svg-inline--fa fa-user-cog fa-w-20" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><path fill="currentColor" d="M610.5 373.3c2.6-14.1 2.6-28.5 0-42.6l25.8-14.9c3-1.7 4.3-5.2 3.3-8.5-6.7-21.6-18.2-41.2-33.2-57.4-2.3-2.5-6-3.1-9-1.4l-25.8 14.9c-10.9-9.3-23.4-16.5-36.9-21.3v-29.8c0-3.4-2.4-6.4-5.7-7.1-22.3-5-45-4.8-66.2 0-3.3.7-5.7 3.7-5.7 7.1v29.8c-13.5 4.8-26 12-36.9 21.3l-25.8-14.9c-2.9-1.7-6.7-1.1-9 1.4-15 16.2-26.5 35.8-33.2 57.4-1 3.3.4 6.8 3.3 8.5l25.8 14.9c-2.6 14.1-2.6 28.5 0 42.6l-25.8 14.9c-3 1.7-4.3 5.2-3.3 8.5 6.7 21.6 18.2 41.1 33.2 57.4 2.3 2.5 6 3.1 9 1.4l25.8-14.9c10.9 9.3 23.4 16.5 36.9 21.3v29.8c0 3.4 2.4 6.4 5.7 7.1 22.3 5 45 4.8 66.2 0 3.3-.7 5.7-3.7 5.7-7.1v-29.8c13.5-4.8 26-12 36.9-21.3l25.8 14.9c2.9 1.7 6.7 1.1 9-1.4 15-16.2 26.5-35.8 33.2-57.4 1-3.3-.4-6.8-3.3-8.5l-25.8-14.9zM496 400.5c-26.8 0-48.5-21.8-48.5-48.5s21.8-48.5 48.5-48.5 48.5 21.8 48.5 48.5-21.7 48.5-48.5 48.5zM224 256c70.7 0 128-57.3 128-128S294.7 0 224 0 96 57.3 96 128s57.3 128 128 128zm201.2 226.5c-2.3-1.2-4.6-2.6-6.8-3.9l-7.9 4.6c-6 3.4-12.8 5.3-19.6 5.3-10.9 0-21.4-4.6-28.9-12.6-18.3-19.8-32.3-43.9-40.2-69.6-5.5-17.7 1.9-36.4 17.9-45.7l7.9-4.6c-.1-2.6-.1-5.2 0-7.8l-7.9-4.6c-16-9.2-23.4-28-17.9-45.7.9-2.9 2.2-5.8 3.2-8.7-3.8-.3-7.5-1.2-11.4-1.2h-16.7c-22.2 10.2-46.9 16-72.9 16s-50.6-5.8-72.9-16h-16.7C60.2 288 0 348.2 0 422.4V464c0 26.5 21.5 48 48 48h352c10.1 0 19.5-3.2 27.2-8.5-1.2-3.8-2-7.7-2-11.8v-9.2z"></path></svg>
            <span class="ml-2 text-sm font-semibold">Settings</span>
        </a>
            </div>
        @endhasrole
        @hasrole('frontdesk')
            <div>
                <a href="#"
                class="flex items-center text-gray-600 py-2 hover:text-blue-700"
                onclick="toggleSubMenu('librarySubmenu', 'libraryIcon')">
                    <svg class="h-4 w-4 fill-current" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512">
                        <path fill="currentColor" d="M610.5 373.3c2.6-14.1 2.6-28.5 0-42.6..."></path>
                    </svg>
                    <span class="ml-2">Subjects</span>
                    <svg id="libraryIcon" class="ml-auto h-4 w-4 transform transition-transform duration-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </a>
                <div id="librarySubmenu" class="hidden pl-6 mt-2">
                    <a href="{{ route('classes.index') }}" class="flex items-center text-gray-600 py-2 hover:text-blue-700">
                        <span class="ml-2 text-sm font-semibold">Academic</span>
                    </a>
                </div>
            </div>
            <script>
                function toggleSubMenu(submenuId) {
                    const submenu = document.getElementById(submenuId);
                    const icon = document.getElementById('feesIcon');
            
                    // Toggle visibility of submenu
                    submenu.classList.toggle('hidden');
            
                    // Rotate the arrow icon
                    if (submenu.classList.contains('hidden')) {
                        icon.classList.remove('rotate-180');
                    } else {
                        icon.classList.add('rotate-180');
                    }
                }
            </script>

            <div>
                <!-- Link to toggle the dropdown -->
                <a href="#"
                class="flex items-center text-gray-600 py-2 hover:text-blue-700 cursor-pointer"
                onclick="toggleSubMenu2('librarySubmenu2', 'libraryIcon2')"
                aria-expanded="false"
                aria-controls="librarySubmenu2">
                    <!-- Icon for "Courses" -->
                    <svg class="h-4 w-4 fill-current" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512">
                        <path fill="currentColor" d="M610.5 373.3c2.6-14.1 2.6-28.5 0-42.6..."></path>
                    </svg>
                    <span class="ml-2">Courses</span>
                    <!-- Dropdown icon -->
                    <svg id="libraryIcon2" class="ml-auto h-4 w-4 transform transition-transform duration-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </a>

                <!-- Dropdown menu -->
                <div id="librarySubmenu2" class="hidden pl-6 mt-2 space-y-1" aria-hidden="true">
                    <a href="{{ route('subject.index') }}" class="flex items-center text-gray-600 py-2 hover:text-blue-700">
                        <span class="ml-2 text-sm font-semibold">Academic</span>
                    </a>
                    <a href="{{ route('diploma.index') }}" class="flex items-center text-gray-600 py-2 hover:text-blue-700">
                        <span class="ml-2 text-sm font-semibold">Professional/Diploma</span>
                    </a>
                </div>
            </div>
            <script>
                // Function to toggle the dropdown
                function toggleSubMenu2(menuId, iconId) {
                    const submenu = document.getElementById(menuId);
                    const icon = document.getElementById(iconId);
                    const isHidden = submenu.classList.contains('hidden');
                    
                    // Toggle visibility
                    submenu.classList.toggle('hidden');
                    submenu.setAttribute('aria-hidden', isHidden ? 'false' : 'true');
            
                    // Rotate icon
                    icon.classList.toggle('rotate-180');
            
                    // Update ARIA-expanded
                    const trigger = document.querySelector(`[aria-controls="${menuId}"]`);
                    trigger.setAttribute('aria-expanded', isHidden ? 'true' : 'false');
                }
            
                // Close dropdown when clicking outside
                document.addEventListener('click', (event) => {
                    const submenu = document.getElementById('librarySubmenu2');
                    const icon = document.getElementById('libraryIcon2');
                    const trigger = document.querySelector('[aria-controls="librarySubmenu2"]');
            
                    if (!submenu.contains(event.target) && !trigger.contains(event.target)) {
                        if (!submenu.classList.contains('hidden')) {
                            submenu.classList.add('hidden');
                            submenu.setAttribute('aria-hidden', 'true');
                            icon.classList.remove('rotate-180');
                            trigger.setAttribute('aria-expanded', 'false');
                        }
                    }
                });
            </script>

            <a href="{{ route('teacher.index') }}" class="flex items-center text-gray-600 py-2 hover:text-blue-700">
                <svg class="h-4 w-4 fill-current" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="user-edit" class="svg-inline--fa fa-user-edit fa-w-20" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><path fill="currentColor" d="M224 256c70.7 0 128-57.3 128-128S294.7 0 224 0 96 57.3 96 128s57.3 128 128 128zm89.6 32h-16.7c-22.2 10.2-46.9 16-72.9 16s-50.6-5.8-72.9-16h-16.7C60.2 288 0 348.2 0 422.4V464c0 26.5 21.5 48 48 48h274.9c-2.4-6.8-3.4-14-2.6-21.3l6.8-60.9 1.2-11.1 7.9-7.9 77.3-77.3c-24.5-27.7-60-45.5-99.9-45.5zm45.3 145.3l-6.8 61c-1.1 10.2 7.5 18.8 17.6 17.6l60.9-6.8 137.9-137.9-71.7-71.7-137.9 137.8zM633 268.9L595.1 231c-9.3-9.3-24.5-9.3-33.8 0l-37.8 37.8-4.1 4.1 71.8 71.7 41.8-41.8c9.3-9.4 9.3-24.5 0-33.9z"></path></svg>
                <span class="ml-2 text-sm font-semibold">Teachers</span>
            </a>

            <a href="{{ route('parents.index') }}" class="flex items-center text-gray-600 py-2 hover:text-blue-700">
                <svg class="h-4 w-4 fill-current" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="user-friends" class="svg-inline--fa fa-user-friends fa-w-20" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><path fill="currentColor" d="M192 256c61.9 0 112-50.1 112-112S253.9 32 192 32 80 82.1 80 144s50.1 112 112 112zm76.8 32h-8.3c-20.8 10-43.9 16-68.5 16s-47.6-6-68.5-16h-8.3C51.6 288 0 339.6 0 403.2V432c0 26.5 21.5 48 48 48h288c26.5 0 48-21.5 48-48v-28.8c0-63.6-51.6-115.2-115.2-115.2zM480 256c53 0 96-43 96-96s-43-96-96-96-96 43-96 96 43 96 96 96zm48 32h-3.8c-13.9 4.8-28.6 8-44.2 8s-30.3-3.2-44.2-8H432c-20.4 0-39.2 5.9-55.7 15.4 24.4 26.3 39.7 61.2 39.7 99.8v38.4c0 2.2-.5 4.3-.6 6.4H592c26.5 0 48-21.5 48-48 0-61.9-50.1-112-112-112z"></path></svg>
                <span class="ml-2 text-sm font-semibold">Parents</span>
            </a>

            <a href="{{ route('student.index') }}" class="flex items-center text-gray-600 py-2 hover:text-blue-700">
                <svg class="h-4 w-4 fill-current" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="user-graduate" class="svg-inline--fa fa-user-graduate fa-w-14" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M319.4 320.6L224 416l-95.4-95.4C57.1 323.7 0 382.2 0 454.4v9.6c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48v-9.6c0-72.2-57.1-130.7-128.6-133.8zM13.6 79.8l6.4 1.5v58.4c-7 4.2-12 11.5-12 20.3 0 8.4 4.6 15.4 11.1 19.7L3.5 242c-1.7 6.9 2.1 14 7.6 14h41.8c5.5 0 9.3-7.1 7.6-14l-15.6-62.3C51.4 175.4 56 168.4 56 160c0-8.8-5-16.1-12-20.3V87.1l66 15.9c-8.6 17.2-14 36.4-14 57 0 70.7 57.3 128 128 128s128-57.3 128-128c0-20.6-5.3-39.8-14-57l96.3-23.2c18.2-4.4 18.2-27.1 0-31.5l-190.4-46c-13-3.1-26.7-3.1-39.7 0L13.6 48.2c-18.1 4.4-18.1 27.2 0 31.6z"></path></svg>
                <span class="ml-2 text-sm font-semibold">Students</span>
            </a>
            <a href="{{ route('student.enquires') }}" class="flex items-center text-gray-600 py-2 hover:text-blue-700">
                <svg class="h-4 w-4 fill-current" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="user-graduate" class="svg-inline--fa fa-user-graduate fa-w-14" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M319.4 320.6L224 416l-95.4-95.4C57.1 323.7 0 382.2 0 454.4v9.6c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48v-9.6c0-72.2-57.1-130.7-128.6-133.8zM13.6 79.8l6.4 1.5v58.4c-7 4.2-12 11.5-12 20.3 0 8.4 4.6 15.4 11.1 19.7L3.5 242c-1.7 6.9 2.1 14 7.6 14h41.8c5.5 0 9.3-7.1 7.6-14l-15.6-62.3C51.4 175.4 56 168.4 56 160c0-8.8-5-16.1-12-20.3V87.1l66 15.9c-8.6 17.2-14 36.4-14 57 0 70.7 57.3 128 128 128s128-57.3 128-128c0-20.6-5.3-39.8-14-57l96.3-23.2c18.2-4.4 18.2-27.1 0-31.5l-190.4-46c-13-3.1-26.7-3.1-39.7 0L13.6 48.2c-18.1 4.4-18.1 27.2 0 31.6z"></path></svg>
                <span class="ml-2 text-sm font-semibold">Enquiry</span>
            </a>
            <div>
                <a href="#"
                    class="flex items-center text-gray-600 py-2 hover:text-blue-700"
                    onclick="toggleSubMenu('feesSubmenu')">
                    <svg class="h-4 w-4 fill-current" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512">
                        <path fill="currentColor" d="M610.5 373.3c2.6-14.1 2.6-28.5 0-42.6..."></path>
                    </svg>
                    <span class="ml-2">Fees</span>
                    <svg class="ml-auto h-4 w-4 transform transition-transform duration-300" id="feesIcon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </a>
                <div id="feesSubmenu" class="hidden pl-6 mt-2">
                    {{-- <a href="{{route('fees.show')}}" class="block px-2 py-1 text-gray-600 hover:bg-gray-200 rounded">Set School Fees</a> --}}
                    {{-- <a href="{{route('fees.collect')}}" class="block px-2 py-1 text-gray-600 hover:bg-gray-200 rounded">Collect School Fees</a> --}}
                    <a href="{{route('fees.defaulters')}}" class="block px-2 py-1 text-gray-600 hover:bg-gray-200 rounded">Defaulters</a>
                </div>
            </div>
            
        @endhasrole
        @role('Student')
            <a href="{{ route('student.books') }}" class="flex items-center text-gray-600 py-2 hover:text-blue-700">
                <svg class="h-4 w-4 fill-current" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="user-cog" class="svg-inline--fa fa-user-cog fa-w-20" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><path fill="currentColor" d="M610.5 373.3c2.6-14.1 2.6-28.5 0-42.6l25.8-14.9c3-1.7 4.3-5.2 3.3-8.5-6.7-21.6-18.2-41.2-33.2-57.4-2.3-2.5-6-3.1-9-1.4l-25.8 14.9c-10.9-9.3-23.4-16.5-36.9-21.3v-29.8c0-3.4-2.4-6.4-5.7-7.1-22.3-5-45-4.8-66.2 0-3.3.7-5.7 3.7-5.7 7.1v29.8c-13.5 4.8-26 12-36.9 21.3l-25.8-14.9c-2.9-1.7-6.7-1.1-9 1.4-15 16.2-26.5 35.8-33.2 57.4-1 3.3.4 6.8 3.3 8.5l25.8 14.9c-2.6 14.1-2.6 28.5 0 42.6l-25.8 14.9c-3 1.7-4.3 5.2-3.3 8.5 6.7 21.6 18.2 41.1 33.2 57.4 2.3 2.5 6 3.1 9 1.4l25.8-14.9c10.9 9.3 23.4 16.5 36.9 21.3v29.8c0 3.4 2.4 6.4 5.7 7.1 22.3 5 45 4.8 66.2 0 3.3-.7 5.7-3.7 5.7-7.1v-29.8c13.5-4.8 26-12 36.9-21.3l25.8 14.9c2.9 1.7 6.7 1.1 9-1.4 15-16.2 26.5-35.8 33.2-57.4 1-3.3-.4-6.8-3.3-8.5l-25.8-14.9zM496 400.5c-26.8 0-48.5-21.8-48.5-48.5s21.8-48.5 48.5-48.5 48.5 21.8 48.5 48.5-21.7 48.5-48.5 48.5zM224 256c70.7 0 128-57.3 128-128S294.7 0 224 0 96 57.3 96 128s57.3 128 128 128zm201.2 226.5c-2.3-1.2-4.6-2.6-6.8-3.9l-7.9 4.6c-6 3.4-12.8 5.3-19.6 5.3-10.9 0-21.4-4.6-28.9-12.6-18.3-19.8-32.3-43.9-40.2-69.6-5.5-17.7 1.9-36.4 17.9-45.7l7.9-4.6c-.1-2.6-.1-5.2 0-7.8l-7.9-4.6c-16-9.2-23.4-28-17.9-45.7.9-2.9 2.2-5.8 3.2-8.7-3.8-.3-7.5-1.2-11.4-1.2h-16.7c-22.2 10.2-46.9 16-72.9 16s-50.6-5.8-72.9-16h-16.7C60.2 288 0 348.2 0 422.4V464c0 26.5 21.5 48 48 48h352c10.1 0 19.5-3.2 27.2-8.5-1.2-3.8-2-7.7-2-11.8v-9.2z"></path></svg>
                <span class="ml-2 text-sm font-semibold">Library &amp Books</span>
            </a> 
            <!-- <a href="{{ route('course.outlineform') }}" class="flex items-center text-gray-600 py-2 hover:text-blue-700">
                <svg class="h-4 w-4 fill-current" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="user-cog" class="svg-inline--fa fa-user-cog fa-w-20" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><path fill="currentColor" d="M610.5 373.3c2.6-14.1 2.6-28.5 0-42.6l25.8-14.9c3-1.7 4.3-5.2 3.3-8.5-6.7-21.6-18.2-41.2-33.2-57.4-2.3-2.5-6-3.1-9-1.4l-25.8 14.9c-10.9-9.3-23.4-16.5-36.9-21.3v-29.8c0-3.4-2.4-6.4-5.7-7.1-22.3-5-45-4.8-66.2 0-3.3.7-5.7 3.7-5.7 7.1v29.8c-13.5 4.8-26 12-36.9 21.3l-25.8-14.9c-2.9-1.7-6.7-1.1-9 1.4-15 16.2-26.5 35.8-33.2 57.4-1 3.3.4 6.8 3.3 8.5l25.8 14.9c-2.6 14.1-2.6 28.5 0 42.6l-25.8 14.9c-3 1.7-4.3 5.2-3.3 8.5 6.7 21.6 18.2 41.1 33.2 57.4 2.3 2.5 6 3.1 9 1.4l25.8-14.9c10.9 9.3 23.4 16.5 36.9 21.3v29.8c0 3.4 2.4 6.4 5.7 7.1 22.3 5 45 4.8 66.2 0 3.3-.7 5.7-3.7 5.7-7.1v-29.8c13.5-4.8 26-12 36.9-21.3l25.8 14.9c2.9 1.7 6.7 1.1 9-1.4 15-16.2 26.5-35.8 33.2-57.4 1-3.3-.4-6.8-3.3-8.5l-25.8-14.9zM496 400.5c-26.8 0-48.5-21.8-48.5-48.5s21.8-48.5 48.5-48.5 48.5 21.8 48.5 48.5-21.7 48.5-48.5 48.5zM224 256c70.7 0 128-57.3 128-128S294.7 0 224 0 96 57.3 96 128s57.3 128 128 128zm201.2 226.5c-2.3-1.2-4.6-2.6-6.8-3.9l-7.9 4.6c-6 3.4-12.8 5.3-19.6 5.3-10.9 0-21.4-4.6-28.9-12.6-18.3-19.8-32.3-43.9-40.2-69.6-5.5-17.7 1.9-36.4 17.9-45.7l7.9-4.6c-.1-2.6-.1-5.2 0-7.8l-7.9-4.6c-16-9.2-23.4-28-17.9-45.7.9-2.9 2.2-5.8 3.2-8.7-3.8-.3-7.5-1.2-11.4-1.2h-16.7c-22.2 10.2-46.9 16-72.9 16s-50.6-5.8-72.9-16h-16.7C60.2 288 0 348.2 0 422.4V464c0 26.5 21.5 48 48 48h352c10.1 0 19.5-3.2 27.2-8.5-1.2-3.8-2-7.7-2-11.8v-9.2z"></path></svg>
                <span class="ml-2 text-sm font-semibold">Course Outline</span>
            </a>  -->
            <div>
                <a href="#"
                    class="flex items-center text-gray-600 py-2 hover:text-blue-700"
                    onclick="toggleSubMenu('feesSubmenu2')">
                    <svg class="h-4 w-4 fill-current" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512">
                        <path fill="currentColor" d="M610.5 373.3c2.6-14.1 2.6-28.5 0-42.6..."></path>
                    </svg>
                    <span class="ml-2">Courses</span>
                    <svg class="ml-auto h-4 w-4 transform transition-transform duration-300" id="feesIcon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </a>
                <div id="feesSubmenu2" class="hidden pl-6 mt-2">
                <a href="{{ route('course.outlineform') }}" class="flex items-center text-gray-600 py-2 hover:text-blue-700">
                    <svg class="h-4 w-4 fill-current" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="user-cog" class="svg-inline--fa fa-user-cog fa-w-20" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><path fill="currentColor" d="M610.5 373.3c2.6-14.1 2.6-28.5 0-42.6l25.8-14.9c3-1.7 4.3-5.2 3.3-8.5-6.7-21.6-18.2-41.2-33.2-57.4-2.3-2.5-6-3.1-9-1.4l-25.8 14.9c-10.9-9.3-23.4-16.5-36.9-21.3v-29.8c0-3.4-2.4-6.4-5.7-7.1-22.3-5-45-4.8-66.2 0-3.3.7-5.7 3.7-5.7 7.1v29.8c-13.5 4.8-26 12-36.9 21.3l-25.8-14.9c-2.9-1.7-6.7-1.1-9 1.4-15 16.2-26.5 35.8-33.2 57.4-1 3.3.4 6.8 3.3 8.5l25.8 14.9c-2.6 14.1-2.6 28.5 0 42.6l-25.8 14.9c-3 1.7-4.3 5.2-3.3 8.5 6.7 21.6 18.2 41.1 33.2 57.4 2.3 2.5 6 3.1 9 1.4l25.8-14.9c10.9 9.3 23.4 16.5 36.9 21.3v29.8c0 3.4 2.4 6.4 5.7 7.1 22.3 5 45 4.8 66.2 0 3.3-.7 5.7-3.7 5.7-7.1v-29.8c13.5-4.8 26-12 36.9-21.3l25.8 14.9c2.9 1.7 6.7 1.1 9-1.4 15-16.2 26.5-35.8 33.2-57.4 1-3.3-.4-6.8-3.3-8.5l-25.8-14.9zM496 400.5c-26.8 0-48.5-21.8-48.5-48.5s21.8-48.5 48.5-48.5 48.5 21.8 48.5 48.5-21.7 48.5-48.5 48.5zM224 256c70.7 0 128-57.3 128-128S294.7 0 224 0 96 57.3 96 128s57.3 128 128 128zm201.2 226.5c-2.3-1.2-4.6-2.6-6.8-3.9l-7.9 4.6c-6 3.4-12.8 5.3-19.6 5.3-10.9 0-21.4-4.6-28.9-12.6-18.3-19.8-32.3-43.9-40.2-69.6-5.5-17.7 1.9-36.4 17.9-45.7l7.9-4.6c-.1-2.6-.1-5.2 0-7.8l-7.9-4.6c-16-9.2-23.4-28-17.9-45.7.9-2.9 2.2-5.8 3.2-8.7-3.8-.3-7.5-1.2-11.4-1.2h-16.7c-22.2 10.2-46.9 16-72.9 16s-50.6-5.8-72.9-16h-16.7C60.2 288 0 348.2 0 422.4V464c0 26.5 21.5 48 48 48h352c10.1 0 19.5-3.2 27.2-8.5-1.2-3.8-2-7.7-2-11.8v-9.2z"></path></svg>
                    <span class="ml-2 text-sm font-semibold">Course Outline</span>
                </a> 
                <a href="{{ route('show.registeredcourses') }} " class="flex items-center text-gray-600 py-2 hover:text-blue-700">
                    <svg class="h-4 w-4 fill-current" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="user-cog" class="svg-inline--fa fa-user-cog fa-w-20" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><path fill="currentColor" d="M610.5 373.3c2.6-14.1 2.6-28.5 0-42.6l25.8-14.9c3-1.7 4.3-5.2 3.3-8.5-6.7-21.6-18.2-41.2-33.2-57.4-2.3-2.5-6-3.1-9-1.4l-25.8 14.9c-10.9-9.3-23.4-16.5-36.9-21.3v-29.8c0-3.4-2.4-6.4-5.7-7.1-22.3-5-45-4.8-66.2 0-3.3.7-5.7 3.7-5.7 7.1v29.8c-13.5 4.8-26 12-36.9 21.3l-25.8-14.9c-2.9-1.7-6.7-1.1-9 1.4-15 16.2-26.5 35.8-33.2 57.4-1 3.3.4 6.8 3.3 8.5l25.8 14.9c-2.6 14.1-2.6 28.5 0 42.6l-25.8 14.9c-3 1.7-4.3 5.2-3.3 8.5 6.7 21.6 18.2 41.1 33.2 57.4 2.3 2.5 6 3.1 9 1.4l25.8-14.9c10.9 9.3 23.4 16.5 36.9 21.3v29.8c0 3.4 2.4 6.4 5.7 7.1 22.3 5 45 4.8 66.2 0 3.3-.7 5.7-3.7 5.7-7.1v-29.8c13.5-4.8 26-12 36.9-21.3l25.8 14.9c2.9 1.7 6.7 1.1 9-1.4 15-16.2 26.5-35.8 33.2-57.4 1-3.3-.4-6.8-3.3-8.5l-25.8-14.9zM496 400.5c-26.8 0-48.5-21.8-48.5-48.5s21.8-48.5 48.5-48.5 48.5 21.8 48.5 48.5-21.7 48.5-48.5 48.5zM224 256c70.7 0 128-57.3 128-128S294.7 0 224 0 96 57.3 96 128s57.3 128 128 128zm201.2 226.5c-2.3-1.2-4.6-2.6-6.8-3.9l-7.9 4.6c-6 3.4-12.8 5.3-19.6 5.3-10.9 0-21.4-4.6-28.9-12.6-18.3-19.8-32.3-43.9-40.2-69.6-5.5-17.7 1.9-36.4 17.9-45.7l7.9-4.6c-.1-2.6-.1-5.2 0-7.8l-7.9-4.6c-16-9.2-23.4-28-17.9-45.7.9-2.9 2.2-5.8 3.2-8.7-3.8-.3-7.5-1.2-11.4-1.2h-16.7c-22.2 10.2-46.9 16-72.9 16s-50.6-5.8-72.9-16h-16.7C60.2 288 0 348.2 0 422.4V464c0 26.5 21.5 48 48 48h352c10.1 0 19.5-3.2 27.2-8.5-1.2-3.8-2-7.7-2-11.8v-9.2z"></path></svg>
                    <span class="ml-2 text-sm font-semibold">Registered Courses</span>
                </a> 
                </div>
            </div>
            

            <a href="https://form.jotform.com/250754187639569" target="_blank" class="flex items-center text-gray-600 py-2 hover:text-blue-700">
                <svg class="h-4 w-4 fill-current" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="user-cog" class="svg-inline--fa fa-user-cog fa-w-20" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><path fill="currentColor" d="M610.5 373.3c2.6-14.1 2.6-28.5 0-42.6l25.8-14.9c3-1.7 4.3-5.2 3.3-8.5-6.7-21.6-18.2-41.2-33.2-57.4-2.3-2.5-6-3.1-9-1.4l-25.8 14.9c-10.9-9.3-23.4-16.5-36.9-21.3v-29.8c0-3.4-2.4-6.4-5.7-7.1-22.3-5-45-4.8-66.2 0-3.3.7-5.7 3.7-5.7 7.1v29.8c-13.5 4.8-26 12-36.9 21.3l-25.8-14.9c-2.9-1.7-6.7-1.1-9 1.4-15 16.2-26.5 35.8-33.2 57.4-1 3.3.4 6.8 3.3 8.5l25.8 14.9c-2.6 14.1-2.6 28.5 0 42.6l-25.8 14.9c-3 1.7-4.3 5.2-3.3 8.5 6.7 21.6 18.2 41.1 33.2 57.4 2.3 2.5 6 3.1 9 1.4l25.8-14.9c10.9 9.3 23.4 16.5 36.9 21.3v29.8c0 3.4 2.4 6.4 5.7 7.1 22.3 5 45 4.8 66.2 0 3.3-.7 5.7-3.7 5.7-7.1v-29.8c13.5-4.8 26-12 36.9-21.3l25.8 14.9c2.9 1.7 6.7 1.1 9-1.4 15-16.2 26.5-35.8 33.2-57.4 1-3.3-.4-6.8-3.3-8.5l-25.8-14.9zM496 400.5c-26.8 0-48.5-21.8-48.5-48.5s21.8-48.5 48.5-48.5 48.5 21.8 48.5 48.5-21.7 48.5-48.5 48.5zM224 256c70.7 0 128-57.3 128-128S294.7 0 224 0 96 57.3 96 128s57.3 128 128 128zm201.2 226.5c-2.3-1.2-4.6-2.6-6.8-3.9l-7.9 4.6c-6 3.4-12.8 5.3-19.6 5.3-10.9 0-21.4-4.6-28.9-12.6-18.3-19.8-32.3-43.9-40.2-69.6-5.5-17.7 1.9-36.4 17.9-45.7l7.9-4.6c-.1-2.6-.1-5.2 0-7.8l-7.9-4.6c-16-9.2-23.4-28-17.9-45.7.9-2.9 2.2-5.8 3.2-8.7-3.8-.3-7.5-1.2-11.4-1.2h-16.7c-22.2 10.2-46.9 16-72.9 16s-50.6-5.8-72.9-16h-16.7C60.2 288 0 348.2 0 422.4V464c0 26.5 21.5 48 48 48h352c10.1 0 19.5-3.2 27.2-8.5-1.2-3.8-2-7.7-2-11.8v-9.2z"></path></svg>
                <span class="ml-2 text-sm font-semibold">Lecturer Evaluation</span>
            </a>
            <a href="{{route('document.request')}} " class="flex items-center text-gray-600 py-2 hover:text-blue-700">
                <svg class="h-4 w-4 fill-current" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="user-cog" class="svg-inline--fa fa-user-cog fa-w-20" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><path fill="currentColor" d="M610.5 373.3c2.6-14.1 2.6-28.5 0-42.6l25.8-14.9c3-1.7 4.3-5.2 3.3-8.5-6.7-21.6-18.2-41.2-33.2-57.4-2.3-2.5-6-3.1-9-1.4l-25.8 14.9c-10.9-9.3-23.4-16.5-36.9-21.3v-29.8c0-3.4-2.4-6.4-5.7-7.1-22.3-5-45-4.8-66.2 0-3.3.7-5.7 3.7-5.7 7.1v29.8c-13.5 4.8-26 12-36.9 21.3l-25.8-14.9c-2.9-1.7-6.7-1.1-9 1.4-15 16.2-26.5 35.8-33.2 57.4-1 3.3.4 6.8 3.3 8.5l25.8 14.9c-2.6 14.1-2.6 28.5 0 42.6l-25.8 14.9c-3 1.7-4.3 5.2-3.3 8.5 6.7 21.6 18.2 41.1 33.2 57.4 2.3 2.5 6 3.1 9 1.4l25.8-14.9c10.9 9.3 23.4 16.5 36.9 21.3v29.8c0 3.4 2.4 6.4 5.7 7.1 22.3 5 45 4.8 66.2 0 3.3-.7 5.7-3.7 5.7-7.1v-29.8c13.5-4.8 26-12 36.9-21.3l25.8 14.9c2.9 1.7 6.7 1.1 9-1.4 15-16.2 26.5-35.8 33.2-57.4 1-3.3-.4-6.8-3.3-8.5l-25.8-14.9zM496 400.5c-26.8 0-48.5-21.8-48.5-48.5s21.8-48.5 48.5-48.5 48.5 21.8 48.5 48.5-21.7 48.5-48.5 48.5zM224 256c70.7 0 128-57.3 128-128S294.7 0 224 0 96 57.3 96 128s57.3 128 128 128zm201.2 226.5c-2.3-1.2-4.6-2.6-6.8-3.9l-7.9 4.6c-6 3.4-12.8 5.3-19.6 5.3-10.9 0-21.4-4.6-28.9-12.6-18.3-19.8-32.3-43.9-40.2-69.6-5.5-17.7 1.9-36.4 17.9-45.7l7.9-4.6c-.1-2.6-.1-5.2 0-7.8l-7.9-4.6c-16-9.2-23.4-28-17.9-45.7.9-2.9 2.2-5.8 3.2-8.7-3.8-.3-7.5-1.2-11.4-1.2h-16.7c-22.2 10.2-46.9 16-72.9 16s-50.6-5.8-72.9-16h-16.7C60.2 288 0 348.2 0 422.4V464c0 26.5 21.5 48 48 48h352c10.1 0 19.5-3.2 27.2-8.5-1.2-3.8-2-7.7-2-11.8v-9.2z"></path></svg>
                <span class="ml-2 text-sm font-semibold">Document Request</span>
            </a>
            <div>
                <a href="#"
                    class="flex items-center text-gray-600 py-2 hover:text-blue-700"
                    onclick="toggleSubMenu('feesSubmenu')">
                    <svg class="h-4 w-4 fill-current" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512">
                        <path fill="currentColor" d="M610.5 373.3c2.6-14.1 2.6-28.5 0-42.6..."></path>
                    </svg>
                    <span class="ml-2">Fees</span>
                    <svg class="ml-auto h-4 w-4 transform transition-transform duration-300" id="feesIcon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </a>
                <div id="feesSubmenu" class="hidden pl-6 mt-2">
                    <a href="{{route('see.fees')}}" class="block px-2 py-1 text-gray-600 hover:bg-gray-200 rounded">School Fees</a>
                    <a href="{{route('fees.history')}}" class="block px-2 py-1 text-gray-600 hover:bg-gray-200 rounded">School Fees History</a>
                </div>
            </div>
            <script>
                function toggleMenu(submenuId) {
                    const submenu = document.getElementById(submenuId);
                    submenu.classList.toggle('hidden');
                }
            </script>
            <script>
                function toggleSubMenu(submenuId) {
                    const submenu = document.getElementById(submenuId);
                    const icon = document.getElementById('feesIcon');
            
                    // Toggle visibility of submenu
                    submenu.classList.toggle('hidden');
            
                    // Rotate the arrow icon
                    if (submenu.classList.contains('hidden')) {
                        icon.classList.remove('rotate-180');
                    } else {
                        icon.classList.add('rotate-180');
                    }
                }
            </script>
        @endrole
    </div>
</div>