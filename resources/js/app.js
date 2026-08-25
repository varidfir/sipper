import './bootstrap';

const uppercaseFieldSelector = [
	'.form-content input[type="text"]',
	'.form-content textarea',
	'.wilayah-form-content input[type="text"]',
].join(', ');

const uppercaseField = (field) => {
	field.value = field.value.toUpperCase();
};

document.addEventListener('input', (event) => {
	if (event.target.matches(uppercaseFieldSelector)) {
		uppercaseField(event.target);
	}
});

document.addEventListener('submit', (event) => {
	event.target.querySelectorAll(uppercaseFieldSelector).forEach(uppercaseField);
});

const recapPage = document.querySelector('[data-recap-page]');

if (recapPage) {
	const recapBody = recapPage.querySelector('[data-recap-body]');
	const recapTotals = recapPage.querySelectorAll('[data-recap-total]');
	const recapCount = recapPage.querySelector('[data-recap-count]');
	const params = new URLSearchParams(window.location.search);

	const formatPeriod = (period, type) => {
		const date = new Date(`${period}${type === 'daily' ? 'T00:00:00' : '-01T00:00:00'}`);

		if (type === 'yearly') return period;
		return new Intl.DateTimeFormat('id-ID', type === 'monthly'
			? { month: 'long', year: 'numeric' }
			: { day: '2-digit', month: 'long', year: 'numeric' }
		).format(date);
	};

	window.axios.get('/api/rekap', {
		params: {
			period: params.get('period') || 'daily',
			year: params.get('year') || new Date().getFullYear(),
			month: params.get('month') || undefined,
			kelompok_pelayanan_id: params.get('kelompok_pelayanan_id') || undefined,
			per_page: 100,
		},
	}).then(({ data }) => {
		const periodType = data.filters.period;
		const total = data.data.reduce((sum, item) => sum + Number(item.total), 0);

		recapBody.innerHTML = data.data.length
			? data.data.map((item, index) => `
				<tr class="transition hover:bg-slate-50">
					<td class="px-4 py-3 text-slate-500 sm:px-5">${index + 1}</td>
					<td class="period px-4 py-3 font-semibold text-slate-800 sm:px-5">${formatPeriod(item.period, periodType)}</td>
					<td class="px-4 py-3 text-right sm:px-5"><span class="recap-number inline-flex min-w-[80px] justify-center rounded-lg bg-blue-50 px-3 py-1.5 font-bold text-blue-700">${item.total}</span></td>
				</tr>`).join('')
			: '<tr><td colspan="3" class="px-5 py-12 text-center text-sm text-slate-500">Tidak ditemukan permohonan berdasarkan filter yang dipilih.</td></tr>';

		recapTotals.forEach((element) => { element.textContent = total; });
		if (recapCount) recapCount.textContent = `${data.data.length} periode`;
	}).catch(() => {});
}
