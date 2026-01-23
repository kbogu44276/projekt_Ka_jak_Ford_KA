document.addEventListener("DOMContentLoaded", () => {
    const forms = document.querySelectorAll("form.js-search");
    if (!forms.length) {
        console.warn("No search forms found");
        return;
    }

    const escapeHtml = (s) => s.replace(/[&<>"']/g, (c) => ({
        "&":"&amp;","<":"&lt;",">":"&gt;","\"":"&quot;","'":"&#39;"
    }[c]));

    forms.forEach((form) => {
        const input = form.querySelector(".search-input");
        const dropdown = form.querySelector(".search-dropdown");
        const suggestUrl = form.dataset.suggestUrl;

        if (!input || !dropdown || !suggestUrl) return;

        let timer = null;
        let items = [];
        let activeIndex = -1;

        const hide = () => {
            dropdown.hidden = true;
            dropdown.innerHTML = "";
        };

        const render = () => {
            if (!items.length) return hide();

            dropdown.innerHTML = items.map((it, idx) => `
                <div class="search-item ${idx === activeIndex ? "active" : ""}"
                     data-idx="${idx}">
                    ${escapeHtml(it.title)}
                </div>
            `).join("");

            dropdown.hidden = false;
        };

        const fetchSuggestions = async () => {
            const q = input.value.trim();
            if (q.length < 3) return hide();

            const res = await fetch(`${suggestUrl}&q=${encodeURIComponent(q)}`);
            if (!res.ok) return hide();

            items = await res.json();
            activeIndex = -1;
            render();
        };

        input.addEventListener("input", () => {
            clearTimeout(timer);
            timer = setTimeout(fetchSuggestions, 250);
        });

        dropdown.addEventListener("mousedown", (e) => {
            const item = e.target.closest(".search-item");
            if (!item) return;

            input.value = item.textContent.trim();
            hide();
            form.submit();
        });
    });
});
