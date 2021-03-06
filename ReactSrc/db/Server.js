const Server = {

  unfilteredSearch() {
    const url = ''; //insert url
    return fetch(url) //no headers
      .then(response => response.json())
      .then(jsonResponse => {
        if (!jsonResponse.usernames) return [];
        return jsonResponse.usernames.items.map(user => {
          return {
            username: user.username,
            watchid: user.watchid,
            borisid: user.borisid,
            team: user.team
          }
        })
      });
  },

  search(term) {
    let searchObject = this.unfilteredSearch();
    let filteredSearch = searchObject.filter(user => user.username.toLowerCase() === term.toLowerCase());
    return filteredSearch;
  },

  saveTeam(name, userBorisIds) {
    if (!name || !userBorisIds) return;
    this.saveToTeam(name);
    this.saveToUsers(this.userborsIds);
  },


  saveToTeam(name) {
    const url =''; //insert url
    return fetch(url, {
      method: 'POST',
      //no headers
      body: JSON.stringify({
        teamName: name
      })
    })
  },

  //sends list of users to have their teamName updated
  saveToUsers(userBorisIds) {
    const url=''; //insert url
    return fetch(url, {
      method: 'POST',
      //no headers
      body: JSON.stringify({
        ids: userBorisIds
      })
    })
  }

};


export default Server;