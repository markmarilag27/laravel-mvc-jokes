interface Joke {
    id: number;
    type: string;
    setup: string;
    punchline: string;
}

interface ApiResponse {
    data: Joke[];
}

declare const axios: any;

const initJokes = (): void => {
    const btn = document.querySelector<HTMLButtonElement>('#refresh-btn');
    const list = document.querySelector<HTMLDivElement>('#joke-list');

    if (!btn || !list) return;

    const fetchAndRenderJokes = async (): Promise<void> => {
        btn.disabled = true;
        btn.textContent = 'Loading...';

        try {
            const response = await axios.get('/api/jokes?limit=3');
            const jokes: Joke[] = response.data.data;

            list.innerHTML = '';

            jokes.forEach((joke: Joke) => {
                const card = `
                    <div class="joke-card p-4 border border-[#19140035] dark:border-[#3E3E3A] rounded-sm transition-all duration-500 opacity-0 translate-y-2">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="text-[10px] uppercase tracking-widest text-[#706f6c] dark:text-[#A1A09A] font-bold">${joke.type}</span>
                        </div>
                        <p class="text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC]">${joke.setup}</p>
                        <p class="text-[13px] text-[#706f6c] dark:text-[#A1A09A] italic mt-1">${joke.punchline}</p>
                    </div>
                `;
                list.insertAdjacentHTML('beforeend', card);
            });

            setTimeout(() => {
                document.querySelectorAll('.joke-card').forEach((el) => {
                    el.classList.remove('opacity-0', 'translate-y-2');
                });
            }, 50);

        } catch (error) {
            list.innerHTML = '<p class="text-sm text-red-600 dark:text-red-400">Failed to load jokes. Please try again.</p>';
            console.error('API Error:', error);
        } finally {
            btn.disabled = false;
            btn.textContent = 'Refresh';
        }
    };

    fetchAndRenderJokes();
    btn.addEventListener('click', fetchAndRenderJokes);
};

initJokes();
