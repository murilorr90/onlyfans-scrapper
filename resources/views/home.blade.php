<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Profile Search</title>
    <style>
        body { font-family: sans-serif; padding: 2rem; }
        .dropdown { border: 1px solid #ccc; max-height: 150px; overflow-y: auto; position: absolute; background-color: white; }
        .dropdown div { padding: 8px; cursor: pointer; }
        .dropdown div:hover { background-color: #eee; }
        .profile-box { margin-top: 2rem; border: 1px solid #ccc; padding: 1rem; border-radius: 8px; }
        .heart { color: red; }
        .search-box { position: relative; width: 300px; margin: 50px auto; }
        .search-box #search { width: 100%; padding: 10px; }
    </style>
</head>
<body>
<div class="search-box">
    <div style="display: inline-flex">
        <input type="text" id="search" placeholder="Search profiles..." autocomplete="off" >
        <button id="scrape" class="disabled" disabled>Scrape</button>
    </div>

    <div id="dropdown" class="dropdown" style="display: none;"></div>
</div>

<div id="profile" class="profile-box" style="display: none;"></div>

<script>
    const search = document.getElementById('search');
    const dropdown = document.getElementById('dropdown');
    const profileBox = document.getElementById('profile');
    const scrape = document.getElementById('scrape');

    search.addEventListener('input', async function () {
        const query = this.value;

        scrape.classList.add('disabled');
        scrape.disabled = true;

        if (query.length < 2) {
            dropdown.style.display = 'none';
            return;
        }

        const res = await fetch(`api/search?q=${query}`);
        const profiles = await res.json();

        dropdown.innerHTML = '';

        if (profiles.length === 0) {
            dropdown.style.display = 'none';
            scrape.classList.remove('disabled');
            scrape.disabled = false;
            return;
        }

        profiles.forEach(profile => {
            const div = document.createElement('div');
            div.textContent = profile.username;
            div.addEventListener('click', () => loadProfile(profile.username));
            dropdown.appendChild(div);
        });

        dropdown.style.display = 'block';
    });

    scrape.addEventListener('click', async function () {
        const username = search.value;
        if (!username) return;


        const res = await fetch(`api/scrape?q=${username}`);
        const scrapeResponse = await res.json();


        if (typeof scrapeResponse.message !== 'undefined') {
            alert(scrapeResponse.message);
            search.value = '';
        }
    });

    async function loadProfile(username) {
        dropdown.style.display = 'none';
        search.value = username;

        const res = await fetch(`api/search?q=${username}`);
        if (!res.ok) {
            profileBox.innerHTML = `<p>Profile not found.</p>`;
            profileBox.style.display = 'block';
            return;
        }

        const data = await res.json();
        const profile = data[0];
        profileBox.innerHTML = `
                <h3><a href="http://onlyfans.com/${profile.username}" target="_blank">@${profile.username}</a></h3>
                <p><strong>${profile.name || 'No name'}</strong></p>
                <p>${profile.bio || ''}</p>
                <p><span class="heart">❤️</span> ${profile.likes} likes</p>
                <small>Last updated: ${profile.updated_at}</small>
            `;
        profileBox.style.display = 'block';
    }
</script>
</body>
</html>
