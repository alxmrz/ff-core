/**
 * Значения свободных ячеек
 * @type {number}
 */
var Cell1 = 0,
    Cell2 = 0,
    Cell3 = 0,
    Cell4 = 0,
    Cell5 = 0,
    Cell6 = 0,
    Cell7 = 0,
    Cell8 = 0,
    Cell9 = 0,
    gameover = false;
/**
 *Начальный игрок
 * @type {string}
 */
var player = "X";
/**
 * @return void Пишет в логи значение каждой ячейки в каждом шаге.
 */
function inLog() {
    console.log("cell1: " + Cell1);
    console.log("cell2: " + Cell2);
    console.log("cell3: " + Cell3);
    console.log("cell4: " + Cell4);
    console.log("cell5: " + Cell5);
    console.log("cell6: " + Cell6);
    console.log("cell7: " + Cell7);
    console.log("cell8: " + Cell8);
    console.log("cell9: " + Cell9);

}
/**
 * Основной процесс в этой функции. Меняем значение ячейки
 * проверяем результат, выйграл ли игрок.
 * @param obj Текущая ячейка
 */
function mainProcess(obj) {
    if (checkCell(obj)) {
        changeVal(obj);
    } else {
        return;
    }
    isGameOver();
    changePlayer();
    if (gameover === false) {
        AI();
        isGameOver();
    }

    changePlayer();
}
/**
 * Проверяет, занял ли игрок 3 клетки подряд.
 * @return void
 */
function isGameOver() {
    var check = checkIfWin();
    if (check === true && check !== 'ничья') {
        alert("Выйграл игрок: " + player);
        location.reload();
        gameover = true;
    } else if (check === 'ничья') {
        alert("Да тут Ничья");

        location.reload();
        gameover = true;
    }

}
/**
 * Меняет значение ячейки в системе
 * @param obj Текущая ячейка
 */
function changeVal(obj) {
    obj.value = player;
    changeCell(obj.id);
}
/**
 * Меняет значение ячейки на экране
 * @param cell
 */
function changeCell(cell) {
    switch (cell) {
        case "cell1":
            Cell1 = player;
            break;
        case "cell2":
            Cell2 = player;
            break;
        case "cell3":
            Cell3 = player;
            break;
        case "cell4":
            Cell4 = player;
            break;
        case "cell5":
            Cell5 = player;
            break;
        case "cell6":
            Cell6 = player;
            break;
        case "cell7":
            Cell7 = player;
            break;
        case "cell8":
            Cell8 = player;
            break;
        case "cell9":
            Cell9 = player;
            break;
    }
}
/**
 * Меняет игрока
 * return void
 */
function changePlayer() {
    if (player === "X") {
        player = "O";

    } else if (player === "O") {
        player = "X";

    }

}
/**
 * Проверяет игру на завершенность шагов.
 * @returns mixed Возвращает true в случае окончания свободных шагов и есть победитель
 * Возвращает false, если есть доступные шаги
 * Возвращает "ничья", если шагов свободных нет и победителя тоже
 */
function checkIfWin() {
    if ((Cell1 === Cell2 && Cell2 === Cell3 && (Cell3 === player)) ||
        (Cell4 === Cell5 && Cell5 === Cell6 && (Cell6 === player)) ||
        (Cell7 === Cell8 && Cell8 === Cell9 && (Cell9 === player)) ||
        (Cell1 === Cell4 && Cell4 === Cell7 && (Cell7 === player)) ||
        (Cell2 === Cell5 && Cell5 === Cell8 && (Cell8 === player)) ||
        (Cell3 === Cell6 && Cell6 === Cell9 && (Cell9 === player)) ||
        (Cell1 === Cell5 && Cell5 === Cell9 && (Cell9 === player)) ||
        (Cell3 === Cell5 && Cell5 === Cell7 && (Cell7 === player))) {

        return true;
    }
    if (Cell1 !== 0 && Cell2 !== 0 && Cell3 !== 0 &&
        Cell4 !== 0 && Cell5 !== 0 && Cell6 !== 0 &&
        Cell7 !== 0 && Cell8 !== 0 && Cell9 !== 0) {
        var game = 'ничья';
        return game;
    }
    return false;
}
/**
 * Имитация Искуственного интеллекта
 * @constructor
 */
function AI() {
    var diflvl = document.getElementById('lvl').value;
    if (diflvl === "Легко") {
        aiWay = AI_Random();
    }
    if (diflvl === "Нормально") {

        var aiWay = AI_Way();

        if (aiWay === false) {
            aiWay = AI_Random();
        }

    }

    if (diflvl === "Сложно") {
        if (Cell5 === "X") {
            var aiWay = AI_Way();

            if (aiWay === false) {
                if (Cell1 === 0) {
                    aiWay = 1
                } else if (Cell3 === 0) {
                    aiWay = 3;
                } else if (Cell7 === 0) {
                    aiWay = 7;
                } else if (Cell9 === 0) {
                    aiWay = 9;
                } else {
                    if (Cell2 === 0) {
                        aiWay = 2;
                    } else if (Cell4 === 0) {
                        aiWay = 4;
                    } else if (Cell6 === 0) {
                        aiWay = 6;
                    } else if (Cell8 === 0) {
                        aiWay = 8;
                    }
                }
            }
        }
        if (Cell5 === 0) {
            var aiWay = 5;
        }
        if (Cell5 === "O") {
            var aiWay = AI_Way();

            if (aiWay === false) {
                if (Cell1 === "X" && Cell3 === 0) {
                    aiWay = 3;
                } else if (Cell3 === "X" && Cell1 === 0) {
                    aiWay = 1;
                } else if (Cell7 === "X" && Cell9 === 0) {
                    aiWay = 9;
                } else if (Cell9 === "X" && Cell7 === 0) {
                    aiWay = 7;
                } else {
                    if (Cell2 === 0) {
                        aiWay = 2;
                    } else if (Cell4 === 0) {
                        aiWay = 4;
                    } else if (Cell6 === 0) {
                        aiWay = 6;
                    } else if (Cell8 === 0) {
                        aiWay = 8;
                    } else
                        aiWay = AI_Random();
                }
                if (Cell1 === "X" && Cell9 === "X" || Cell3 === "X" && Cell7 === "X") {
                    if (Cell2 === 0) {
                        aiWay = 2;
                    } else if (Cell4 === 0) {
                        aiWay = 4;
                    } else if (Cell6 === 0) {
                        aiWay = 6;
                    } else if (Cell8 === 0) {
                        aiWay = 8;
                    }
                }

            }
        }
    }
    var obj = document.getElementById("cell" + aiWay);
    switch (aiWay) {
        case 1:
            obj.value = player;
            Cell1 = player;
            break;
        case 2:
            obj.value = player;
            Cell2 = player;
            break;

        case 3:
            obj.value = player;
            Cell3 = player;
            break;
        case 4:
            obj.value = player;
            Cell4 = player;
            break;
        case 5:
            obj.value = player;
            Cell5 = player;
            break;
        case 6:
            obj.value = player;
            Cell6 = player;
            break;
        case 7:
            obj.value = player;
            Cell7 = player;
            break;
        case 8:
            obj.value = player;
            Cell8 = player;
            break;
        case 9:
            obj.value = player;
            Cell9 = player;
            break;
    }

}
/**
 * Ищет ячейки, которые могут завершить игру, т.е. 2 занятые подряд от любого игрока
 * @returns {*}
 * @constructor
 */
function AI_Way() {
// Первая горизонтальная строка
    if (Cell1 === Cell2 && Cell2 !== 0 && Cell3 === 0) {
        return aiWay = 3;
    } else if (Cell1 === Cell3 && Cell3 !== 0 && Cell2 === 0) {
        return aiWay = 2;
    } else if (Cell2 === Cell3 && Cell3 !== 0 && Cell1 === 0) {
        return aiWay = 1;
    }
// Вторая горизонтальная строка
    else if (Cell4 === Cell5 && Cell5 !== 0 && Cell6 === 0) {
        return aiWay = 6;
    } else if (Cell5 === Cell6 && Cell6 !== 0 && Cell4 === 0) {
        return aiWay = 4;
    } else if (Cell4 === Cell6 && Cell6 !== 0 && Cell5 === 0) {
        return aiWay = 5;
    }
//Третья горизонтальная строка
    else if (Cell7 === Cell8 && Cell8 !== 0 && Cell9 === 0) {
        return aiWay = 9;
    } else if (Cell7 === Cell9 && Cell9 !== 0 && Cell8 === 0) {
        return aiWay = 8;
    } else if (Cell8 === Cell9 && Cell9 !== 0 && Cell7 === 0) {
        return aiWay = 7;
    }
//Первая вертикальная строка
    else if (Cell1 === Cell4 && Cell4 !== 0 && Cell7 === 0) {
        return aiWay = 7;
    } else if (Cell1 === Cell7 && Cell7 !== 0 && Cell4 === 0) {
        return aiWay = 4;
    } else if (Cell4 === Cell7 && Cell7 !== 0 && Cell1 === 0) {
        return aiWay = 1;
    }
//Вторая вертикальная строка
    else if (Cell2 === Cell5 && Cell5 !== 0 && Cell8 === 0) {
        return aiWay = 8;
    } else if (Cell2 === Cell8 && Cell8 !== 0 && Cell5 === 0) {
        return aiWay = 5;
    } else if (Cell5 === Cell8 && Cell8 !== 0 && Cell2 === 0) {
        return aiWay = 2;
    }
//Третья вертикальная строка
    else if (Cell3 === Cell6 && Cell6 !== 0 && Cell9 === 0) {
        return aiWay = 9;
    } else if (Cell3 === Cell9 && Cell9 !== 0 && Cell6 === 0) {
        return aiWay = 6;
    } else if (Cell6 === Cell9 && Cell9 !== 0 && Cell3 === 0) {
        return aiWay = 3;
    }
//Первая наклонная строка
    else if (Cell1 === Cell5 && Cell5 !== 0 && Cell9 === 0) {
        return aiWay = 9;
    } else if (Cell1 === Cell9 && Cell9 !== 0 && Cell5 === 0) {
        return aiWay = 5;
    } else if (Cell5 === Cell9 && Cell9 !== 0 && Cell1 === 0) {
        return aiWay = 1;
    }
//Вторая наклонная строка
    else if (Cell3 === Cell5 && Cell5 !== 0 && Cell7 === 0) {
        return aiWay = 7;
    } else if (Cell3 === Cell7 && Cell7 !== 0 && Cell5 === 0) {
        return aiWay = 5;
    } else if (Cell5 === Cell7 && Cell7 !== 0 && Cell3 === 0) {
        return aiWay = 3;
    } else {
        return false
    }
    ;
}
/**
 * Делает рандомный ход в свободную клетку
 * Используется при слабом уровне сложности и при не возможности расчитать дальнейший ход
 * @returns {number}
 */
function AI_Random() {
    for (var x = true; x === true;) {
        var aiWay = Math.floor((Math.random() * 9) + 1);
        var obj = document.getElementById("cell" + aiWay);
        if (checkCell(obj) === false) {
            continue;
        } else {
            x = false;
        }
    }
    return aiWay;
}
/**
 * Проверяет, свободна ли ячейка
 * @param obj Текущая ячейка
 * @returns {boolean}
 */
function checkCell(obj) {
    if (obj.value !== " ")
        return false;
    return true;
}
