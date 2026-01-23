(() => {
    const forms = document.querySelectorAll("form.js-search");
    if (!forms.length) return;

    const escapeHtml = (s) => s.replace(/[&<>"']/g, (c) => ({
        "&":"&amp;","<":"&lt;",">":"&gt;","\"":"&quot;","'":"&#39;"
    }[c]));

    forms.forEach((form) => {
        const input = form.querySelector("input.search-input");
        const dropdown = form.querySelector(".search-dropdown");
        const suggestUrl = form.dataset.suggestUrl;

        if (!input || !dropdown || !suggestUrl) return;

        let timer = null;
        let items = [];
        let activeIndex = -1;

        const hide = () => {
            dropdown.hidden = true;
            dropdown.innerHTML = "";
            items = [];
            activeIndex = -1;
        };

        const show = () => { dropdown.hidden = false; };

        const render = () => {
            if (!items.length) return hide();

            dropdown.innerHTML = items.map((it, idx) => `
        <div class="search-item ${idx === activeIndex ? "active" : ""}" data-idx="${idx}">
          ${escapeHtml(it.title)}
        </div>
      `).join("");
            show();
        };

        const fetchSuggestions = async () => {
            const q = input.value.trim();
            if (q.length < 3) return hide();

            const url = `${suggestUrl}&q=${encodeURIComponent(q)}`;
            const res = await fetch(url, { headers: { "Accept": "application/json" } });
            if (!res.ok) return hide();

            items = await res.json();
            activeIndex = -1;
            render();
        };

        input.addEventListener("input", () => {
            clearTimeout(timer);
            timer = setTimeout(fetchSuggestions, 200);
        });

        input.addEventListener("keydown", (e) => {
            if (dropdown.hidden) return;

            if (e.key === "ArrowDown") {
                e.preventDefault();
                activeIndex = Math.min(activeIndex + 1, items.length - 1);
                render();
            } else if (e.key === "ArrowUp") {
                e.preventDefault();
                activeIndex = Math.max(activeIndex - 1, 0);
                render();
            } else if (e.key === "Escape") {
                hide();
            } else if (e.key === "Enter") {
                // Enter = przejście do strony wyników.
                // Jeśli wybrana sugestia – wypełnij input tytułem.
                if (activeIndex >= 0 && items[activeIndex]) {
                    input.value = items[activeIndex].title;
                    hide();
                }
                // submit zostaje naturalnie
            }
        });

        dropdown.addEventListener("mousedown", (e) => {
            const el = e.target.closest(".search-item");
            if (!el) return;

            const idx = parseInt(el.dataset.idx, 10);
            if (!Number.isFinite(idx) || !items[idx]) return;

            input.value = items[idx].title;
            hide();
            form.submit();
        });

        document.addEventListener("click", (e) => {
            if (e.target === input || dropdown.contains(e.target) || form.contains(e.target)) return;
            hide();
        });
    });
})();
