var signup = document.getElementById('signup')
var login = document.getElementById('login')
 
signup.onclick = function(e){
  e.target.className = e.target.className.replace('levelDown','levelUp')
  login.className = login.className.replace('levelUp','levelDown')
}
 
login.onclick = function(e){
  e.target.className = e.target.className.replace('levelDown','levelUp')
  signup.className = signup.className.replace('levelUp','levelDown')
}