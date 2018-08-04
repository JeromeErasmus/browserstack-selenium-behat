import React from "react";
import PropTypes from "prop-types";
import axios from "axios";
import {BootstrapTable, TableHeaderColumn} from 'react-bootstrap-table';
import {
  Link
} from 'react-router-dom';
import ListItem from './../ListItem/ListItem';

class Layout extends React.Component {
  static propTypes = {
    children: PropTypes.node,
    filePath: PropTypes.string,
  };

  static defaultProps = {
    children: null,
    filePath: ''
  };

  constructor(props) {
    super(props);
    this.state = {
      data: [],
      hashed_id: '',
      logs: '',
      browser: '',
      browser_version: '',
      os: '',
      os_version: ''
    };
  }

  componentDidMount() {
    if (this.props.filePath) {
      this.fetchFile(this.props.filePath)
    }
  }

  async fetchFile(filePath) {
    const root = this;
    return axios
      .get(filePath, {
        params: {}
      })
      .then(function(response) {
        if(response && response.data) {
          const sessionData = response.data.automation_session;
          root.setState({
            hashed_id: sessionData.hashed_id,
            logs: sessionData.logs,
            browser: sessionData.browser,
            browser_version: sessionData.browser_version,
            os: sessionData.os,
            os_version: sessionData.os_version
          });
          root.setState({data: [sessionData]})
          console.log(response.data);
        }
      })
      .catch(function(error) {
        console.log(error);
      });
  };

  createListItem() {
    return (
      <ListItem
        hashed_id={this.state.hashed_id}
        browser={this.state.browser}
        browser_version={this.state.browser_version}
        os={this.state.os}
        os_version={this.state.os_version}
      />
    )
  }

  buttonFormatter(value) {
    return (
      <a href={value} target="_blank">View</a>
    )
  }

  rowClassNameFormat(row) {
    if(!row) {
      return '';
    }
    return row.status;
  }

  render() {
    return (
      <div>
        <BootstrapTable
        data={ this.state.data }
        trClassName={this.rowClassNameFormat}>
          <TableHeaderColumn
            dataField='hashed_id' 
            isKey={ true }>Session ID</TableHeaderColumn>
          <TableHeaderColumn
            dataField='result'>Result</TableHeaderColumn>
          <TableHeaderColumn
            dataField='logs'
            dataFormat={this.buttonFormatter}>Logs</TableHeaderColumn>
          <TableHeaderColumn
            dataField='public_url'
            dataFormat={this.buttonFormatter}>Public Logs</TableHeaderColumn>
          <TableHeaderColumn
            dataField='browser_console_logs_url'
            dataFormat={this.buttonFormatter}>Console Logs</TableHeaderColumn>
        </BootstrapTable>
      </div>
    );
  }
}

export default Layout;
