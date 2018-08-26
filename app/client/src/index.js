import React from 'react';
import ReactDOM from 'react-dom';
import { BrowserRouter } from 'react-router-dom'
import './index.css';
import App from './App';
import registerServiceWorker from './registerServiceWorker';
import 'bootstrap/dist/css/bootstrap.css';
import './../node_modules/react-bootstrap-table/dist/react-bootstrap-table-all.min.css';
import './../node_modules/react-bootstrap-table/dist/react-bootstrap-table.min.js';

ReactDOM.render(
    (
    <BrowserRouter>
        <App />
    </BrowserRouter>
    ),document.getElementById('root'));
registerServiceWorker();
