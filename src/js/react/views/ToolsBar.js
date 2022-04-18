import View from './View';

class ToolsBar extends View 
{
    constructor(props)
    {
        super(props, {
            app: null
        }, {
            set_state: true
        });

        this.state = {
            opened: false,
            barContent: null
        };
    }

    render()
    {
        const openedClass = this.state.opened ? ' enabled' : '';

        return (
            <div className={this.getViewClass(openedClass)}>
                {/* <TileOptions app={this.app} /> */}
                {this.state.barContent}
            </div>
        );
    }
}

export default ToolsBar;
