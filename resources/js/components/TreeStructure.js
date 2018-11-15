import React, { Component } from 'react';
import SortableTree, { addNodeUnderParent, removeNodeAtPath, changeNodeAtPath } from 'react-sortable-tree';
import 'react-sortable-tree/style.css'; // This only needs to be imported once in your app

const new_node = {
    title: '',
    name: '',
    children: [],
    expanded: false
}
const minContainerSize = 300;

export default class TreeStructure extends Component {
    constructor(props) {
        super(props);

        this.state = {
                treeData: []
            // treeData: [{
            //     title: 'Peter Olofsson',
            //     name: 'Peter Olofsson',
            //     children: [],
            //     expanded: false
            //
            // }, {
            //     title: 'Karl Johansson',
            //     name: 'Karl Johansson',
            //     children: [],
            //     expanded: false
            // }]
        };
    }

    componentDidMount = () => {
        this.getTreeData();
    }

    // componentDidUpdate = () => {
    //     console.log("hehe",$(".rst__tree [role='rowgroup']").length);
    // }

    resizeContainer = () => {

        console.log("container height",$(".rst__tree [role='rowgroup']").length);
        if($(".rst__tree [role='rowgroup']").length) {
            let tree_height = parseInt($(".rst__tree [role='rowgroup']").css('height').replace("px", ""));
            console.log(tree_height);

            if (tree_height > minContainerSize) {
                this.container.style.height = tree_height + "px";
            }
        }
    }

    getTreeData = () => {
        /*Fetch API for post request */
        fetch( '/api/get_tree', {
            method:'post',
            /* headers are important*/
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },

            body: JSON.stringify(this.state)
        })
            .then(response => {
                return response.json()
            })
            .then( data => {
                // console.log("API get",typeof data,typeof data.treeData);
                // console.log(typeof data.treeData !== "undefined");

                if(typeof data.treeData !== "undefined") {
                    this.setState(data, () => {
                        // console.log("edit name",this.state);
                        // console.log("hehe",$(".rst__tree [role='rowgroup']").length);
                        this.resizeContainer();
                    });
                }
                //this.setState({ redirectToNewPage: "/films/"+this.processFilmName(data.name) })

            })
    }

    saveTreeData = () => {
        /*Fetch API for post request */
        fetch( '/api/save_tree', {
            method:'post',
            /* headers are important*/
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },

            body: JSON.stringify(this.state)
        })
            .then(response => {
                return response.json();
            })
            .then( data => {
                console.log("API save",data);
                //this.setState({ redirectToNewPage: "/films/"+this.processFilmName(data.name) })

            })
    }

    handleStateChange = (type) => {
        this.resizeContainer();
        this.saveTreeData();
    }

    render() {
        const getNodeKey = ({ treeIndex }) => treeIndex;
        const getRandomName = () =>
            firstNames[Math.floor(Math.random() * firstNames.length)];
        return (
            <div>
                <div ref={c => { this.container = c }} style={{ height: minContainerSize }}>
                    <SortableTree
                        onMoveNode={()=>{
                            this.handleStateChange("move");
                            console.log("move",this.state);
                        }}
                        // onVisibilityToggle={()=>{
                        //     this.handleStateChange("visibility toggle");
                        //     console.log("visib",this.state);
                        // }}
                        onVisibilityToggle={(args) => {
                            this.setState( args.treeData , () => {
                                this.handleStateChange("visibility changed");
                                console.log("visib",this.state);
                            })
                            //console.log("args",args.treeData);
                        }}
                        treeData={this.state.treeData}
                        onChange={treeData => this.setState({ treeData })}
                        generateNodeProps={({ node, path }) => ({
                            title: (
                                <input
                                    style={{ fontSize: '1.1rem' }}
                                    value={node.name}
                                    onChange={event => {
                                        const name = event.target.value;

                                        this.setState(state => ({
                                            treeData: changeNodeAtPath({
                                                treeData: state.treeData,
                                                path,
                                                getNodeKey,
                                                newNode: { ...node, name, title:name }
                                            }),
                                        }), () => {
                                            console.log("edit name",this.state);
                                        });
                                    }}
                                    onBlur={event => {
                                        this.handleStateChange("blur after edit");
                                        console.log("blur",this.state);

                                    }}
                                />
                            ),
                            buttons: [
                                <button
                                    onClick={() =>
                                        this.setState(state => ({
                                            treeData: addNodeUnderParent({
                                                treeData: state.treeData,
                                                parentKey: path[path.length - 1],
                                                expandParent: true,
                                                getNodeKey,
                                                newNode: new_node,
                                                addAsFirstChild: state.addAsFirstChild,
                                            }).treeData,
                                        }), () => {
                                            this.handleStateChange("add child");
                                            console.log("add",this.state);
                                        })
                                    }
                                >
                                    Add Child
                                </button>,
                                <button
                                    onClick={() =>
                                        this.setState(state => ({
                                            treeData: removeNodeAtPath({
                                                treeData: state.treeData,
                                                path,
                                                getNodeKey,
                                            }),
                                        }), () => {
                                            this.handleStateChange("remove");
                                            console.log("remove",this.state);
                                        })
                                    }
                                >
                                    Remove
                                </button>,
                            ],
                        })}
                    />
                </div>

                <button
                    onClick={() =>
                        this.setState(state => ({
                            treeData: state.treeData.concat(new_node),
                        }), () => {
                            this.handleStateChange("add more");
                            console.log("add more",this.state);
                        })
                    }
                >
                    Add more
                </button>

            </div>
        );
    }
}