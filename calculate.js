function disable() {
    document.getElementById('nb1').setAttribute("disabled", "")
    document.getElementById('nb1b').setAttribute("disabled", "")
    document.getElementById('otherTeam').setAttribute("disabled", "")
}

function enable() {
    document.getElementById('nb1').removeAttribute("disabled", "")
    document.getElementById('nb1b').removeAttribute("disabled", "")
    document.getElementById('otherTeam').removeAttribute("disabled", "")

}

function calculate() {

    function numberWithSpaces(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " "); //reg ex, extra space after 3 chars
    }

    function diffYear(d) {
        let today = new Date();
        let dd = String(today.getDate()).padStart(2, '0');
        let mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
        let yyyy = today.getFullYear();
        today = yyyy + '-' + mm + '-' + dd;
        let currentDate = new Date(today);
        let inputDate = new Date(d);
        return Math.floor(Math.abs(((currentDate.getTime() - inputDate.getTime()) / (24 * 60 * 60 *
            1000)) / 365.242199)); // hours*minutes*seconds*milliseconds
    }
    let d1 = document.getElementById('d1').value;
    let d2 = document.getElementById('d2').value;

    //to academy?
    let toAcademy = (document.getElementById('ac').checked) ? true : false;

    //next club
    let nb1 = (document.getElementById('nb1').checked) ? true : false;
    let nb2 = (document.getElementById('nb1b').checked) ? true : false;
    let otherTeam = (document.getElementById('otherTeam').checked) ? true : false;

    //international caps
    let youth = (document.getElementById('ifi').checked) ? true : false;
    let junior = (document.getElementById('junior').checked) ? true : false;
    let senior = (document.getElementById('felnott').checked) ? true : false;
    let YouthSH = (document.getElementById('upsk').checked) ? true : false;
    let SeniorSH = (document.getElementById('fsk').checked) ? true : false;

    age = diffYear(d1);
    elapsedYears = diffYear(d2);
    //NB1 -be bárhonnan
    Cost = 0;
    if (!toAcademy && nb1) {
        if (age >= 10 && age < 13) {
            Cost = 150000;
        } else if (age >= 13 && age < 15) {
            Cost = 200000;
        } else if (age >= 15 && age < 17) {
            Cost = 300000;
        } else if (age >= 17 && age < 19) {
            Cost = 350000;
        } else if (age >= 19 && age < 21) {
            Cost = 400000;
        } else if (age >= 21 && age < 23) {
            Cost = 450000;
        } else Cost = 0;
    } else if (!toAcademy && nb2) {
        if (age >= 10 && age < 13) {
            Cost = 100000;
        } else if (age >= 13 && age < 15) {
            Cost = 120000;
        } else if (age >= 15 && age < 17) {
            Cost = 160000;
        } else if (age >= 17 && age < 19) {
            Cost = 200000;
        } else if (age >= 19 && age < 23) {
            Cost = 250000;
        } else Cost = 0;
    } else if (!toAcademy && otherTeam) {
        if (age >= 10 && age < 13) {
            Cost = 50000;
        } else if (age >= 13 && age < 15) {
            Cost = 70000;
        } else if (age >= 15 && age < 23) {
            Cost = 100000;
        } else Cost = 0;
    } else { //akadémiába bárhonnan
        if (age < 15) {
            Cost = 2000000;
        } else if (age >= 15 && age < 17) {
            Cost = 3000000;
        } else if (age >= 17 && age < 19) {
            Cost = 4000000;
        } else if (age >= 19 && age < 21) {
            Cost = 5000000;
        }
    }
    let basicFee = Cost;
    let odds = 1;
    if ((!toAcademy) && (elapsedYears >= 3)) {
        odds = Math.pow(1.20, elapsedYears - 2)
        Cost *= odds;

    } else if (toAcademy && elapsedYears < 3) {
        odds = 0.7;
        Cost *= odds;
    }
    //international cap odds
    icOdds = 1;
    if (youth) {
        icOdds = 2;
        Cost *= icOdds;
    } else if (junior) {
        icOdds = 3;
        Cost *= icOdds;
    } else if (senior) {
        icOdds = 5;
        Cost *= icOdds;
    } else if (YouthSH) {
        icOdds = 1.5;
        Cost *= icOdds;
    } else if (SeniorSH) {
        icOdds = 3;
        Cost *= icOdds;
    }

    document.getElementById("out0").innerHTML = numberWithSpaces(Math.round(basicFee)) + " Ft";
    document.getElementById("out1").innerHTML = numberWithSpaces(Math.round(Cost)) + " Ft";
    document.getElementById("out2").innerHTML = numberWithSpaces(Math.round(Cost * 1.27)) + " Ft";
    document.getElementById("out3").innerHTML = isNaN(age) ? 0 : age + " Év";
    document.getElementById("out4").innerHTML = isNaN(elapsedYears) ? 0 : elapsedYears + " Év";
    document.getElementById("out5").innerHTML = isNaN(elapsedYears) ? 1 : (odds * icOdds).toFixed(
        5);

}