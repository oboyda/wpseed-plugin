import View from './View';
import TileOptions from './TileOptions';

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
            enabled: false,
            barContent: null
        };
    }

    getDefaultContent()
    {
        return <TileOptions app={this.app} />;
    }

    render()
    {
        const enabledClass = this.state.enabled ? ' enabled' : '';

        return (
            <div className={this.getViewClass(enabledClass)}>
                {this.state.barContent ? this.state.barContent : this.getDefaultContent()}
                {!this.state.enabled ? (
                    <div className='disabler-overlay'></div>
                ) : null}
            </div>
        );
    }
}

export default ToolsBar;
