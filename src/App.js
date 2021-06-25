import Login from "./components/Login";
import {BrowserRouter as Router,Switch,Route} from "react-router-dom";
import Header from "./components/Header.js";
import Loginpage from './components/loginpage';
import CheckBox from './components/checkbox';
import Register from './components/register';
import ForgetPassword from './components/forgotpassword';
import Detail from './components/detail';
import Test from './components/manager'
import react,{useState} from 'react';
import HeaderLoged from "./components/headerLoged";
function App() {
  const [user, setUser] = useState('');
  const [reg, setreg] = useState(false);
  return (
    <div className="App">
      <Router>
        {user?(<HeaderLoged user={user} setUser={setUser}/>):(<Header />)}
        <Switch>
            <Route exact path="/">
              <Login />
            </Route>
            <Route path="/loginpage">
            <Loginpage user={user} setUser={setUser}/>
            </Route>
            <Route path="/checkbox">
              <CheckBox />
            </Route>
            <Route path="/register">
            <Register reg={reg} setreg={setreg}/>
            </Route>
            <Route path="/forgetpassword">
              <ForgetPassword />
            </Route>
            <Route path="/result">
              <Detail />
            </Route>
            <Route path="/manager">
              <Test user={user} />
            </Route>
        </Switch>
      </Router>
    </div>
  );
}
export default App;
// function App() {
//   return (
//     <div className="App">
//       <Router>
//       <Header />
//         <Switch>
//             <Route exact path="/">
//               <Login />
//             </Route>
//             <Route exact path="/loginpage">
//               <Loginpage />
//             </Route>
//             <Route exact path="/checkbox">
//               <CheckBox />
//             </Route>
//             <Route exact path="/register">
//               <Register />
//             </Route>
//             <Route  exact path="/forgetpassword">
//               <ForgetPassword />
//             </Route>
//             <Route exact path="/result">
//             <SearchResult/>
//             </Route>
//             <Route exact path ="/test">
//               <Mappy/>
//             </Route>
//             <Route path="/manager">
//                 <Test/>
//             </Route>
//         </Switch>
//       </Router>
//     </div>
//   );
// }

// export default App;