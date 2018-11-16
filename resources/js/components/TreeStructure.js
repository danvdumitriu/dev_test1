import React, { Component } from 'react';
import SortableTree, { addNodeUnderParent, removeNodeAtPath, changeNodeAtPath } from 'react-sortable-tree';
import 'react-sortable-tree/style.css'; // This only needs to be imported once in your app

const new_node = {
    title: 'new',
    name: 'new',
    children: [],
    expanded: false
}
const api_endpoint = 'api/tree';

const minContainerSize = 300;

export default class TreeStructure extends Component {
    constructor(props) {
        super(props);

        this.state = {
            error: "",
            treeData: []
        };
    }

    componentDidMount = () => {
        this.getTreeData();

        let checkExist = setInterval(() => {
            if ($(".rst__tree [role='rowgroup']").length) {
                this.resizeContainer();
                clearInterval(checkExist);
            }
        }, 300); // check every 300ms
    }

    resizeContainer = () => {

        if($(".rst__tree [role='rowgroup']").length) {
            let tree_height = parseInt($(".rst__tree [role='rowgroup']").css('height').replace("px", ""));

            if (tree_height > minContainerSize) {
                this.container.style.height = tree_height + "px";
            }
        }
    }

    getTreeData = () => {
        /*Fetch API for post request */
        fetch( api_endpoint, {
            method:'get',
            /* headers are important*/
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })
            .then(response => {
                return response.json()
            })
            .then( data => {

                if(typeof data.treeData !== "undefined") {
                    this.setState(data, () => {

                        this.resizeContainer();
                    });
                }

            })
    }

    saveTreeData = () => {
        /*Fetch API for post request */
        fetch( api_endpoint, {
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
                if (response.ok) {
                    return response.json();
                } else {
                    this.setState({
                        error: "The tree structure won't be persisted after page refresh unless you register or login"
                    });
                }
            })
            .catch((error) => {
                console.log(error)
            });
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
                <div style={{"color":"red"}}>{this.state.error}</div>
                <div ref={c => { this.container = c }} style={{ height: minContainerSize }}>
                    <SortableTree
                        onMoveNode={()=>{
                            this.handleStateChange("move");
                        }}

                        onVisibilityToggle={(args) => {
                            this.setState( args.treeData , () => {
                                this.handleStateChange("visibility changed");
                            })
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
                                        }));
                                    }}
                                    onBlur={event => {
                                        this.handleStateChange("blur after edit");

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
                        })
                    }
                >
                    Add more
                </button>

            </div>
        );
    }
}