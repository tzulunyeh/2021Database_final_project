import React from 'react';
import ReactDOM from 'react-dom';
import './index.css';
import App from './App';
import Loginpage from './components/loginpage';
import GoogleMapTest from './components/googlemap'


ReactDOM.render(
  <React.StrictMode>
    {<App />}
    {/* {<GoogleMapTest />} */}
  </React.StrictMode>,
  document.getElementById('root')
);


