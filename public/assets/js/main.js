let dayProduction = 'Monday'
let daySettings = 'Monday'

setInterval(() => {
    getdata(document.querySelector("#id").textContent)
}, 1000)
function getdata(id) {
    fetch('/allData/' + id)
        .then((response) => response.json())
        .then((data) => {
            document.querySelector("#boardHR").textContent = data[0].speed_realtime
            if (data[0].status_realtime === "true") {
                document.querySelector("#statu").textContent = "ON"
                document.querySelector("#statu").className = "clr-green"
                document.querySelector("#btnON").className = "btn-on"
                document.querySelector("#btnOFF").className = "btn-off"
            } else {
                document.querySelector("#statu").textContent = "OFF"
                document.querySelector("#statu").className = "clr-red"
                document.querySelector("#btnON").className = "btn-OFFon"
                document.querySelector("#btnOFF").className = "btn-ONoff"
            }
            document.querySelector("#piece").textContent = data[0].piece_counter
            document.querySelector("#remaining").textContent = data[0].remaining
            document.querySelector("#prrogris").style.width = Number(data[0].remaining) * 100 / Number(data[0].cycleTime) + "%"
            document.querySelector("#cycleTime").textContent = data[0].cycleTime
            document.querySelector("#cycleTimeProd").textContent = data[0].cycleTime
            document.querySelector("#mode_realtime").textContent = data[0].mode_realtime

        });
}
document.querySelector("#prod").addEventListener('click', () => {
    document.querySelector("#production").classList.toggle('none')
})

document.querySelector("#btnM").addEventListener('click', () => {
    Number(document.querySelector('#valueBoard').value) > 0 ? document.querySelector('#valueBoard').value = Number(document.querySelector('#valueBoard').value - 1) : document.querySelector('#valueBoard').value = 0
    changedValueBoard()
})
document.querySelector("#btnP").addEventListener('click', () => {
    document.querySelector('#valueBoard').value = Number(document.querySelector('#valueBoard').value) + 1
    changedValueBoard()
})

document.querySelector("#production .settings").addEventListener('click', () => {
    document.querySelector("#downtime").classList.add('none')
    document.querySelector("#settings").classList.remove('none')
})
document.querySelector("#production .downtime").addEventListener('click', () => {
    document.querySelector("#downtime").classList.remove('none')
    document.querySelector("#settings").classList.add('none')
    getDowntime()
})
function getDowntime() {
    document.querySelector("#cnt_downtime_add").innerHTML = ''
    fetch('/downtime/' + dayProduction)
        .then((response) => response.json())
        .then((data) => {
            data.forEach(element => {
                let div = document.createElement('div')
                let p = document.createElement('p')
                let input = document.createElement('input')
                let button = document.createElement('button')
                let span = document.createElement('span')
                span.textContent = element.id
                span.classList.add('none')

                button.classList.add('delete')
                button.textContent = 'Delete'
                button.setAttribute('onclick', 'remove(this)')

                input.setAttribute('type', 'time')
                input.value = element.timeStop

                p.textContent = 'step : '

                div.classList.add('card')
                div.classList.add('ds-flx')
                div.classList.add('aln-btw')

                div.append(p)
                div.append(input)
                div.append(button)
                div.append(span)

                document.querySelector("#cnt_downtime_add").append(div)
            });
        });
}
function remove(elm) {
    elm.parentElement.remove()
    fetch('/delete/DELETE FROM `dbeasy_line`.`downtime` WHERE id =' + elm.parentElement.children[3].textContent)
}
function getLight() {
    document.querySelector("#cnt-light-add").innerHTML = ''
    fetch('/light/' + daySettings)
        .then((response) => response.json())
        .then((data) => {
            data.forEach(element => {
                let div = document.createElement('div')
                let p = document.createElement('p')
                let input = document.createElement('input')
                let p2 = document.createElement('p')
                let input2 = document.createElement('input')
                let button = document.createElement('button')
                let span = document.createElement('span')
                span.textContent = element.id
                span.classList.add('none')

                button.classList.add('delete')
                button.textContent = 'Delete'
                button.setAttribute('onclick', 'removee(this)')

                input.setAttribute('type', 'time')
                input.value = element.timeStart
                input2.setAttribute('type', 'time')
                input2.value = element.timeStop


                p.textContent = 'ON'
                p2.textContent = 'OFF'

                div.classList.add('card')
                div.classList.add('ds-flx')
                div.classList.add('aln-btw')

                div.append(p)
                div.append(input)
                div.append(p2)
                div.append(input2)
                div.append(button)
                div.append(span)

                document.querySelector("#cnt-light-add").append(div)
            });
        });
}
function removee(elm) {
    elm.parentElement.remove()
    fetch('/delete/DELETE FROM `dbeasy_line`.`lighting` WHERE id =' + elm.parentElement.children[5].textContent)
}

document.querySelector("#btnAdd").addEventListener('click', () => {
    let div = document.createElement('div')
    let p = document.createElement('p')
    let input = document.createElement('input')
    let button = document.createElement('button')

    button.classList.add('delete')
    button.textContent = 'Delete'
    button.setAttribute('onclick', 'remove(this)')

    input.setAttribute('type', 'time')
    input.setAttribute('onchange', 'addRow(this)')

    p.textContent = 'step : '

    div.classList.add('card')
    div.classList.add('ds-flx')
    div.classList.add('aln-btw')

    div.append(p)
    div.append(input)
    div.append(button)

    document.querySelector("#cnt_downtime_add").append(div)
})
function addRow(a) {
    fetch("/add/INSERT INTO `dbeasy_line`.`downtime` (`timeStop`,`timeAdded`, `Day`) VALUES ('" + a.value + "',NOW(),'" + dayProduction + "' );")
    getDowntime()
}
document.querySelector("#alr").addEventListener('click', () => {
    document.querySelector("#alarms").classList.toggle('none')
    document.querySelector('#tbody').innerHTML = ''
    fetch('/alarm')
        .then((response) => response.json())
        .then((data) => {
            data.forEach(element => {
                let div = document.createElement('div')
                let div1 = document.createElement('div')
                let div2 = document.createElement('div')
                div.classList.add('tr')
                div.classList.add('ds-flx')
                div.classList.add('aln-btw')
                div1.classList.add('td')
                div1.textContent = element.status
                div2.classList.add('td')
                div2.textContent = element.dateStatus
                div.append(div1)
                div.append(div2)
                document.querySelector('#tbody').append(div)
            });
        });

})
document.querySelector("#settings_ .light").addEventListener('click', () => {
    document.querySelector("#language").classList.add('none')
    document.querySelector("#light").classList.remove('none')
    getLight()
})
document.querySelector("#settings_ .language").addEventListener('click', () => {
    document.querySelector("#language").classList.remove('none')
    document.querySelector("#light").classList.add('none')
})
document.querySelector("#sett").addEventListener('click', () => {
    document.querySelector("#settings_").classList.toggle('none')
    getLight()
})
document.querySelector("#btnAdd_").addEventListener('click', () => {
    let div = document.createElement('div')
    let p = document.createElement('p')
    let input = document.createElement('input')
    let p2 = document.createElement('p')
    let input2 = document.createElement('input')
    let button = document.createElement('button')

    button.classList.add('delete')
    button.textContent = 'Delete'
    button.setAttribute('onclick', 'removee(this)')

    input.setAttribute('type', 'time')
    input2.setAttribute('type', 'time')
    input.setAttribute('onchange', 'addRoww(this)')
    input2.setAttribute('onchange', 'addRoww(this)')

    p.textContent = 'ON'
    p2.textContent = 'OFF'

    div.classList.add('card')
    div.classList.add('ds-flx')
    div.classList.add('aln-btw')

    div.append(p)
    div.append(input)
    div.append(p2)
    div.append(input2)
    div.append(button)

    document.querySelector("#cnt-light-add").append(div)
})
function addRoww(elm) {
    if (elm.parentElement.children[1].value !== "" && elm.parentElement.children[3].value !== "") {
        fetch("/add/INSERT INTO `dbeasy_line`.`lighting` (`timeStart`, `timeStop`, `timeAdd`,`Day`) VALUES ('" + elm.parentElement.children[1].value + "', '" + elm.parentElement.children[3].value + "',NOW(),'" + daySettings + "');")
        getLight()
    }
}

function clickDayProduction(a) {
    dayProduction = a.textContent;
    getDowntime()
}
function clickDaySetting(a) {
    daySettings = a.textContent;
    getLight()
}
function btnOn() {
    fetch("/update/UPDATE rotary_lines SET `status` = 'true' WHERE id = " + document.querySelector("#id").textContent)
}
function btnOff() {
    fetch("/update/UPDATE rotary_lines SET `status` = 'false' WHERE id = " + document.querySelector("#id").textContent)
}
function changedMode() {
    s= document.querySelector("#modeselectChanged").value
    fetch("/update/UPDATE rotary_lines SET `mode` = '" + s + "' WHERE id = " + document.querySelector("#id").textContent)
    // document.querySelector("#modeSelect").textContent = s
    // document.querySelector("#crcModeSelect").className = s
}
document.querySelector("#valueBoard").addEventListener('change', () => {
    changedValueBoard()

})
function changedValueBoard() {
    if (document.querySelector("#mode_realtime").textContent === "Continuous" && Number(document.querySelector("#valueBoard").value) > 0 && Number(document.querySelector("#valueBoard").value) < 34) {
        fetch("/update/UPDATE rotary_lines SET `speed` = " + Number(document.querySelector("#valueBoard").value) + " WHERE id = " + document.querySelector("#id").textContent)
    } else if (document.querySelector("#mode_realtime").textContent === "Discontinuous" && Number(document.querySelector("#valueBoard").value) > 0 && Number(document.querySelector("#valueBoard").value) < 201) {
        fetch("/update/UPDATE rotary_lines SET `speed` = " + Number(document.querySelector("#valueBoard").value) + " WHERE id = " + document.querySelector("#id").textContent)
    }
}
