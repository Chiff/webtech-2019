class comboSettings {
    constructor(props) {
        this.queryString = props.queryString;
        this.defaultValue = props.defaultValue;

        this.itemList = props.itemList || $(props.queryString).children('li').map((it, el) => el.innerHTML).get();
        this.isFilled = !(!!props.itemList) && !props.isAsync; // ak neexistuje itemList tak je naplneny z html a zaroven nie je async

        this.isAsync = props.isAsync || false;
        this.codeTableUrl = props.codeTableUrl || undefined
    }
}

/**
 * const a = combo({queryString: '#worktime-list', itemList: ['0 - 10', '10 - 20','viac ako 20']});
 * const a = combo({queryString: '#worktime-list', isAsync: true, codeTableUrl: 'url});
 * const a = combo({queryString: '#worktime-list'});
 *
 * @param props: {queryString: Sting, itemList?: Array, isAsync?: boolean, codeTableUrl: String}
 */
export function combo(props) {
    const settings = new comboSettings(props);
    const $this = $(settings.queryString);

    $this.parent('.combo-wrapper').each(function () {
        $('input', this).keydown(function (e) {
            e.preventDefault()
        });

        $('input', this).focus(function () {
            $this.slideDown()
        });

        $('input', this).focusout(function () {
            setTimeout(function () {
                $this.slideUp()
            }, 50)
        })
    });

    const init = () => {
        if (!settings.isFilled) {
            fillToHtml(settings.itemList)
        }
        clickRegister()
    };

    const async = () => {
        setComboMessage($this, 'Udaje sa načítavajú');

        $.ajax({
            url: settings.codeTableUrl,
            type: 'GET',
            success: function (data) {
                settings.itemList = data;

                if(settings.defaultValue && settings.defaultValue !== 0)
                    $this.parent().find('input').attr('value', data.filter(e => e.id === settings.defaultValue)[0].name);

                init()
            },
            error: function () {
                setComboMessage($this, 'Nepodarilo sa načítať tieto údaje');
                console.log(arguments)
            }
        })

    };

    const setComboMessage = ($combo, msg) => {
        $combo.empty();
        $combo.append(
            '<li data-disabled="true">' + msg + '</li>'
        )
    };

    const fillToHtml = (data) => {
        $this.empty();
        for (let d = 0; d < data.length; d++) {
            if (data[d].name && data[d].id) {
                $this.append(
                    '<li data-id="' + data[d].id + '">' + data[d].name + '</li>'
                )
            } else {
                $this.append(
                    '<li>' + data[d] + '</li>'
                )
            }
        }
    };

    const clickRegister = () => {
        $this.children('li').each(function () {
            $(this).click(function () {
                $(this).parent()
                    .parent()
                    .find('input')
                    .val($(this).text());

                if (settings.isAsync) {
                    $(this).parent().parent().find('input').attr('data-id', $(this).attr('data-id'));
                }
            })
        })
    };

    if (settings.isAsync) {
        async()
    } else {
        init()
    }
}
