<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    @vite('resources/css/app.css')
</head>

<body class="min-h-screen bg-gray-100 flex flex-col items-center p-2 sm:p-4">

    <!-- Conteneur principal -->
    <div class="bg-white p-4 sm:p-6 rounded shadow-md w-full max-w-5xl">

        <!-- Titre -->
        <h1 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-4 sm:mb-6 text-center">
            Dashboard
        </h1>

        <!-- Sélecteurs -->
        <div class="flex flex-wrap justify-center gap-2 sm:gap-4 mb-4 sm:mb-6">

            <!-- Date -->
            <div class="relative">
                <button id="cally1" class="px-4 py-2 sm:px-6 sm:py-3 text-lg sm:text-xl font-bold rounded-lg border border-gray-400 hover:border-gray-600">
                    Date de la session
                </button>

                <div id="cally-popover1" class="hidden absolute z-50 mt-1 left-0">
                    <div class="p-4 border rounded-lg bg-white shadow-lg">
                        <calendar-date class="cally">
                            <calendar-month></calendar-month>
                        </calendar-date>
                    </div>
                </div>
            </div>

            <!-- Type -->
            <div class="relative">
                <button id="course-btn" class="px-4 py-2 sm:px-6 sm:py-3 text-lg sm:text-xl font-bold rounded-lg border border-gray-400 hover:border-gray-600">
                    Type de course
                </button>

                <div id="course-popover" class="hidden absolute z-50 mt-1 left-0 bg-white rounded-lg shadow-md border">
                    <ul class="py-2">
                        <li><button class="w-full text-left px-4 py-2 hover:bg-gray-100" data-type="VMA">VMA</button></li>
                        <li><button class="w-full text-left px-4 py-2 hover:bg-gray-100" data-type="VMAX">Vitesse Max</button></li>
                    </ul>
                </div>
            </div>

        </div>

        <!-- Images -->
        <div id="image-container" class="grid gap-4 grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
        </div>

    </div>

    <!-- ✅ OVERLAY CORRIGÉ -->
    <div id="zoom-overlay"
         style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; z-index:9999; background:rgba(0,0,0,0.8); padding:1rem; align-items:center; justify-content:center;">

        <div style="position:relative; display:flex; justify-content:center; align-items:center; width:100%; height:100%;">

            <img id="zoom-img"
                 style="max-width:90vw; max-height:90vh; object-fit:contain; border-radius:8px; box-shadow:0 10px 30px rgba(0,0,0,0.5);">

            <div id="zoom-caption"
                 style="position:absolute; bottom:10px; left:50%; transform:translateX(-50%); background:rgba(0,0,0,0.7); color:white; padding:8px 12px; border-radius:6px;">
            </div>

            <button id="zoom-close"
                    style="position:absolute; top:10px; right:10px; color:white; font-size:28px; font-weight:bold; background:none; border:none; cursor:pointer;">
                &times;
            </button>

        </div>
    </div>

    <script type="module" src="https://unpkg.com/cally"></script>

    <script>
        const button = document.getElementById('cally1');
        const popover = document.getElementById('cally-popover1');
        const courseBtn = document.getElementById('course-btn');
        const coursePopover = document.getElementById('course-popover');
        const imageContainer = document.getElementById('image-container');

        const zoomOverlay = document.getElementById('zoom-overlay');
        const zoomImg = document.getElementById('zoom-img');
        const zoomCaption = document.getElementById('zoom-caption');
        const zoomClose = document.getElementById('zoom-close');

        let selectedDate = null;
        let selectedCourseType = null;

        // Calendrier
        button.addEventListener('click', () => popover.classList.toggle('hidden'));
        document.addEventListener('click', (e) => {
            if (!button.contains(e.target) && !popover.contains(e.target)) popover.classList.add('hidden');
        });

        const calendar = document.querySelector('calendar-date.cally');
        calendar.addEventListener('change', function() {
            selectedDate = this.value;
            button.innerText = selectedDate;
            loadImages();
            popover.classList.add('hidden');
        });

        // Type
        courseBtn.addEventListener('click', () => coursePopover.classList.toggle('hidden'));
        coursePopover.querySelectorAll('button').forEach(btn => {
            btn.addEventListener('click', () => {
                selectedCourseType = btn.dataset.type;
                courseBtn.innerText = btn.innerText;
                loadImages();
                coursePopover.classList.add('hidden');
            });
        });

        document.addEventListener('click', (e) => {
            if (!courseBtn.contains(e.target) && !coursePopover.contains(e.target)) {
                coursePopover.classList.add('hidden');
            }
        });

        // Charger images
        function loadImages() {
            if (!selectedDate || !selectedCourseType) return;

            imageContainer.innerHTML = 'Chargement...';

            fetch(`/api/images/${selectedDate}/${selectedCourseType}`)
                .then(res => res.json())
                .then(images => {
                    imageContainer.innerHTML = '';

                    images.forEach(img => {
                        const wrapper = document.createElement('div');
                        wrapper.className = "cursor-pointer";

                        const imgEl = document.createElement('img');
                        imgEl.src = img.url;
                        imgEl.className = "w-full h-48 object-cover rounded";

                        wrapper.addEventListener('click', () => {
                            zoomImg.src = img.url;
                            zoomCaption.innerText = img.title ?? '';
                            zoomOverlay.style.display = 'flex';
                        });

                        wrapper.appendChild(imgEl);
                        imageContainer.appendChild(wrapper);
                    });
                });
        }

        // Fermer
        zoomClose.addEventListener('click', () => {
            zoomOverlay.style.display = 'none';
        });

        zoomOverlay.addEventListener('click', (e) => {
            if (e.target === zoomOverlay) {
                zoomOverlay.style.display = 'none';
            }
        });
    </script>

</body>
</html>