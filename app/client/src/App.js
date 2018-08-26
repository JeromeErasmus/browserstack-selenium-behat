import React, { Component } from 'react';
import './App.css';
import Header from './components/Header/Header';
import Layout from './components/Layout/Layout';
import ListView from './components/ListView/ListView';

class App extends Component {
  render() {
    return (
      <div className="App">
        <Header></Header>
        <Layout>
          <ListView filePath={'results.log'}/>
        </Layout>
      </div>
    );
  }
}

export default App;
