export const config = {
	language: null,
	defaultUrl: null,
};

export function translate(data) {
	$('[data-translate]').each(function () {
		const $this = $(this);

		$this.contents()
			.filter(function () {
				return this.nodeType === 3;
			}).map(function () {
			const val = this.nodeValue.trim();
			//	console.log(val);
			if (!(!!data[val]) || data[val] === '')
				return;

			let replace = data[val];

			//	console.log(data[val]);

			if (this.nodeValue[0] === ' ')
				replace = ' ' + replace;
			if (this.nodeValue[this.nodeValue.length - 1] === ' ')
				replace += ' ';

			this.nodeValue = replace;
		});
	});
}


export function fetch() {
	return new Promise((resolve, reject) => {
		if (config.language === 'sk') {
			resolve({});
			return;
		}

		$.get({
			url: config.defaultUrl + `/assets/resources/${config.language.toLowerCase()}.json`,
			success: function (data) {
				resolve(data);
			},
			error: function (error) {
				reject(error);
			}
		});
	});
}
